<?php


namespace App\Helpers\Grid\Components;

use App\Helpers\Grid\ComponentConvertDataTrait;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class AjaxList extends Component
{
    use ComponentConvertDataTrait;

    public $id = 'grid_ajax_list';
    public $pagination;

    /**
     * @var array [ { params.column of GridSearch config } => like grid available of GridSearch config ]
     */
    protected $config;

    public function __construct($config = [], $query = null, $id = null)
    {
        $this->setConfig($config);
        $this->setPagination($query);
        $this->setId($id);
    }

    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    public function setPagination($query)
    {
        $this->pagination = $query ? $query->paginate(
                request($this->id . '__search_perPage', array_key_first(config('params.perPageOptions'))
            )) : null;

        return $this;
    }

    public function setId($value = null)
    {
        if ($value) {
            $this->id = $value;
        }
        return $this->id;
    }

    public function columns($key = null)
    {
        return $key ? $this->config[$key] : $this->config;
    }

    public function renderTd($item, $key, $loop = null)
    {
        $settings = $this->columns($key);

        $outer = @$settings['outer'];
        if (is_callable($outer)) {
            return $outer($item, $loop, $this);
        } elseif ($outer) {
            return $outer;
        }

        $attr = @$settings['attrTd'];

        $inner = @$settings['inner'];
        if (is_callable($inner)) {
            $inner = $inner($item, $key, $loop, $this);
        } elseif (!$inner && $convertFn = $this->getConvertDataMethod(@$settings['convert'], $params)) {
            $inner = $this->$convertFn($item, $key, $loop, $params);
        } elseif (!$inner) {
            $inner = e(data_get($item, $key));
        }

        if (isset($settings['empty_data']) && empty($inner)) {
            $inner = $settings['empty_data'];
        }

        return "<td $attr>{$inner}</td>";
    }

    public function getConvertDataMethod($name, &$params)
    {
        $params = [];
        $arr = explode(":", $name);
        $name = @$arr[0];
        $convertFn = Str::camel('get_'.$name.'_convert_data');

        if (isset($arr[1])) {
            $params = explode(",", $arr[1]);
        }

        return method_exists(ComponentConvertDataTrait::class, $convertFn) ? $convertFn : null;
    }

    public function dataCollection()
    {
        return $this->pagination ? $this->pagination->getCollection() : [];
    }

    public function getSearchData($key = null)
    {
        return request($this->id . '__search');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return function ($data) {
            $slot = $data['slot'];
            $id = $data['id'];

            return "<div id=\"$id\">
                <div id=\"{$id}__search\">$slot</div>
                <div id=\"{$id}__result\" class=\"mt-5\">
                </div>
            </div>";
        };
    }

    public function renderView()
    {
        return view('grid::ajax-list', $this->data());
    }
}