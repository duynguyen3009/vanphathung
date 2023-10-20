<?php

use App\Helpers\Common;

return [
    '元' => [
        'active' => 1,
        'skipOrderBy' => true,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => "hin_cd",
            'operator' => '=',
            'value' => null,
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => '',
            'inner' => function ($item, $key, $loop, $ResultTable) {
                return "<button type='button' class='btn btn-sm btn-warning grid-transform-link moto' 
                data-hin_cd='{$item->hin_cd}' data-hin_nm='{$item->hin_nm}'>元</button>";
            },
            'attrTd' => 'class="text-center" width="1%"'
        ],
    ],
    'hin_cd' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'hin_cd',
            'operator' => 'like',
            'value' => '%{param}%',
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => trans('attributes.m_hinmoku.hin_cd'),
            'attrTd' => 'class="text-center"'
        ],
    ],
    'hin_nm' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'hin_nm',
            'operator' => 'like',
            'value' => '%{param}%',
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => trans('attributes.m_hinmoku.hin_nm'),
            'inner' => function ($item, $key, $loop, $ResultTable) {
                return '<a class="grid-transform-link" 
                    data-transform_search="'.e(json_encode($ResultTable->GridSearch->gridSearchForm['data'])).'"
                    data-href="'.e(route('hanbai_kojo_hinmoku.spec', [
                        'hin_cd' => $item->hin_cd,
                        'hin_nm' => $item->hin_nm,
                    ])).'"> '.e($item->hin_nm).'</a>';
            },
        ],
    ],
    'hin_kbn' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'hin_kbn',
            'operator' => '=',
            'value' => null,
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => trans('attributes.m_hinmoku.hin_kbn'),
            'inner' => function ($item, $key, $loop, $ResultTable) {
                return e(data_get($ResultTable->GridSearch->gridResultTable, "hin_kbn_all.{$item->$key}" ?? ''));
            },
        ],
    ],
    'cnt_ktn_cd' => [
        'active' => 1,
        'params' => [
            'column' => 'cnt_ktn_cd',
            'operator' => '=',
            'value' => '{param}',
            'boolean' => null
        ],
        'method' => 'where',
        //grid-column
        'grid' => [
            'header' => '登録拠点数',
            'attrTd' => 'class="text-right"'
        ],
    ],
    'ktn_cd_all' => [
        'active' => 1,
        'skipOrderBy' => true,
        'params' => [
            'column' => 'ktn_cd_all',
            'operator' => null,
            'value' => null,
            'closure' => function ($query, $v) {
                $query->whereRaw(Common::makeEscapeLikeWhere(
                    "',' || ktn_cd_all || ','",
                    str_replace(
                        '{param}',
                        Common::makeEscapeStr(",{$v},", true),
                        '%{param}%'
                    ))
                    , null
                );
            },
            'boolean' => null
        ],
        'method' => 'where',
        //grid-column
        'grid' => [
            'header' => '拠点',
            'inner' => function ($item, $key, $loop, $ResultTable) {
                $ktn_cd = explode(",", $item->ktn_cd_all);
                $ktnCdElements = [];
                foreach ($ktn_cd as $value) {
                    $value = intval($value);
                    $ktn_nm = $ResultTable->GridSearch->gridResultTable['ktn_cd_all'][$value] ?? '';

                    $ktnCdElements[] = '<a class="grid-transform-link" 
                        data-transform_search="'.e(json_encode($ResultTable->GridSearch->gridSearchForm['data'])).'"
                        data-href="'.e(route('hanbai_kojo_hinmoku.spec', [
                            'hin_cd' => $item->hin_cd,
                            'hin_nm' => $item->hin_nm,
                            'ktn_cd' => $value
                        ])).'">'.e($ktn_nm).'</a>';
                }
                $ktnCdElement = implode('、', $ktnCdElements);
                return $ktnCdElement;
            },
            'attrTd' => 'class="text-left"'
        ],
    ],

];
