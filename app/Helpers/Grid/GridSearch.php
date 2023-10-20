<?php

namespace App\Helpers\Grid;


use App\Helpers\Common;
use App\Helpers\Mst;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class GridSearch
{
    public $appendData = [
        'grid_numbered',
        'grid_chosen',
    ];

    public $gridSearchForm = [
        'data' => [],
        'name' => 'GridSearchForm',
    ];
    public $gridResultTable = [
        'data' => [],
        'name' => 'GridResultTable',
        'sorting' => []
    ];

    public $orderByDefault = [];

    public $customOrderByFnc = null;

    public $sortabled = true;

    /**
     * @var \Illuminate\Contracts\Pagination\LengthAwarePaginator|Paginator
     */
    public $pagination;

    private $_screenCd;
    private $_config;

    function __construct($screenCd = '')
    {
        $this->_screenCd = $screenCd;

        if (strpos($this->_screenCd, 'mst_') !== false) {
            $mst = new Mst($this->_screenCd);
            $numberedAttr = [
                'numbered' => [
                    'mapping' => false,
                    'grid' => [
                        'header' => '',
                        'convert' => 'grid_numbered',
                    ],
                ],
            ];
            $configs = array_merge($numberedAttr, $mst::getConfig($this->_screenCd));
            foreach ($configs as $key => $conf) {
                if (!isset($configs[$key]['active'])) {
                    $configs[$key]['active'] = 1;
                }
            }
            $this->_config = $configs;
        } else {
            $this->_config = self::getConfig($this->_screenCd);
        }

        $this->gridSearchForm['data'] = json_decode(request('transform_search', ''), true);
        //dd($_REQUEST, $this->gridSearchForm, json_decode());
        $this->gridSearchForm['data'] = request($this->gridSearchForm['name'],
            $this->gridSearchForm['data'] ?? []);
        //dd($_REQUEST, $this->gridSearchForm['data']);
        //logger(print_r($this->gridSearchForm['data'], true));
        $this->gridResultTable['data'] = request($this->gridResultTable['name'], []);
    }
    function getScreenCd()
    {
        return $this->_screenCd;
    }

    static function getConfig($csreenCd)
    {
        if (!$csreenCd) {
            return [];
        }
        $config = require(app_path('Helpers/Grid/config/'."{$csreenCd}.php"));
        $prioritize = config("grids.{$csreenCd}");
        foreach ($config as $k => $v) {
            if (@$config[$k]['mapping'] === false) {
                continue;
            }
            if (isset($prioritize[$k])) {
                $config[$k]['active'] = $prioritize[$k];
            }
        }
        return $config;
    }
    function getOwnConfig()
    {
        return $this->_config;
    }
    function setConfig($config)
    {
        $this->_config = $config;
    }

    public function activeColumns($key = null)
    {
        $active = Arr::where($this->_config, function ($col) {
            return $col['active'] === 1;
        });

        return $key ? $active[$key] : $active;
    }

    function getSelectOptions($name='')
    {
        $opts = [];
        foreach ($this->_config as $k => $v) {
            if ($v['active'] && @$v['mapping'] !== false && @$v['selectOpt'] !== false) {
                $push = true;
                if (!empty($name) && @$v['skip' . ucfirst($name)] === true) $push = false;
                if ($push) {
                    $opts[$k] = $v['grid']['label'] ?? $v['grid']['header'];
                }
            }
        }

        return $opts;
    }

    function buildConditions($conds = [], $combinedOperator = 'AND', $groupWhere = false, Builder $qb = null)
    {
        $configs = $this->_config;

        $qb = $qb ?? new Builder(DB::connection());

        if ($groupWhere) {
            $qb->where(function ($query) use ($configs, $conds, $combinedOperator) {
                $this->buildWhereClause($configs, $conds, $combinedOperator,$query);
            });
        } else {
            $this->buildWhereClause($configs, $conds, $combinedOperator,$qb);
        }

        return $qb;
    }

    private function buildWhereClause($configs, $conds, $combinedOperator, &$qb){
        foreach ($conds as $cond) {
            $k = $cond['name'];
            $v = $cond['value'];
            if (!isset($configs[$k])) {
                continue;
            }
            $config = $configs[$k];
            if (!$config['active']) {
                continue;
            }
            $notSupport = false;

            $method = $config['method'];
            switch ($method) {
                case 'where':
                    switch ($config['params']['operator']) {
                        case 'like':
                            $qb->whereRaw(Common::makeEscapeLikeWhere(
                                $config['params']['column'],
                                str_replace(
                                    '{param}',
                                    Common::makeEscapeStr($v, true),
                                    $config['params']['value']
                                ))
                                , null
                                , $combinedOperator
                            );
                            $notSupport = true;
                            break;
                        default:
                            if (isset($config['params']['closure'])
                                && $config['params']['closure'] instanceof \Closure
                                && is_null($config['params']['operator'])
                            ) {
                                $closure = $config['params']['closure'];
                                $config['params']['column'] = function ($query) use ($closure, $v) {
                                    $closure($query, $v);
                                };
                                unset($config['params']['closure']);
                            } else {
                                $config['params']['value'] = $v;
                            }
                    }
                    $config['params']['boolean'] = $combinedOperator;
                    break;
                default: //none support
                    $notSupport = true;

            }
            if ($notSupport) {
                continue;
            }
            $qb->$method(...array_values($config['params']));
        }
    }

    public function paginate($mainQuery, $whereEx = null, $getQueryBuilder = false)
    {
        $q = $this->applySearchConds($mainQuery, $whereEx);
        if ($this->customOrderByFnc instanceof \Closure) {
            $fnc = $this->customOrderByFnc;
            $fnc($q);
        } else {
            $this->applyOrderBy($q);
        }

        $qb = clone $q;
        $this->pagination = $q->paginate($this->getPerPageSearch());
        if ($getQueryBuilder) return $qb;
    }

    public function applySearchConds($mainQuery, $whereEx = null, $alias = 'main')
    {
        $q = $this->buildConditions(
            $this->getWhereSearch(),
            $this->getWhereBooleanSearch(),
            true
        )->fromSub($mainQuery, $alias);
        if (!empty($whereEx)) {
            $q->where($whereEx);
        }

        return $q;
    }

    public function applyOrderBy(&$q) {
        $orderBy = Arr::wrap($this->getOrderBySearch($direction));
        $orderBy = array_unique(array_merge($orderBy, $this->orderByDefault));
        $beSet = false;
        foreach ($orderBy as $i => $k) {
            if (!empty($k) && $beSet==false) {
                $this->gridResultTable['sorting'] = ['col' => $k, 'direction' => $direction];
                $beSet = true;
            }
            $q->orderBy($k, $direction);
        }
    }

    public function getWhereSearch()
    {
        return data_get($this->gridSearchForm, 'data.where', []);
    }

    public function getWhereBooleanSearch()
    {
        return data_get($this->gridSearchForm, 'data.whereBoolean', 'AND');
    }

    public function getOrderBySearch(&$direction = 'asc')
    {
        $orderBy = explode(':', data_get($this->gridSearchForm, 'data.orderBy', ''));
        $key = $orderBy[0] ?? '';
        $direction = $orderBy[1] ?? 'asc';
        $config = $this->getSelectOptions();
        if (!isset($config[$key])) {
            $key = array_key_first($config);
        }
        return @$this->_config[$key]['params']['column'];
    }

    public function getPerPageSearch()
    {
        return data_get($this->gridSearchForm, 'data.perPage',
            array_key_first(config('params.perPageOptions')));
    }

    public function getOtherWhereSearch()
    {
        return is_array($this->gridSearchForm['data'])
            ? Arr::except($this->gridSearchForm['data'], ['where', 'whereBoolean', 'orderBy', 'perPage'])
            : [];
    }

    public static function createDataTransformSearchDropdown($conditions = [], $config = []){
        if (is_array($conditions) && is_array($config)) {
            foreach ($conditions as $number => $valuesSearch) {
                $keyExist = array_key_exists($valuesSearch['name'], $config);
                if ($keyExist === false) {
                    unset($conditions[$number]);
                }
            }
        }
        $conditions     = !empty($conditions) ? array_combine(range(1, count($conditions)), array_values($conditions)) : [];//UPDATE ARRAY AFTER UNSET
        return $conditions;
    }
}
