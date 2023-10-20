<?php
return [
    '詳細' => [
        'active' => 1,
        'skipOrderBy' => true,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => "tok_cd",
            'operator' => '=',
            'value' => null,
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => '詳細',
            'inner' => function($item, $key, $loop, $ResultTable) {
                return '<a class="btn btn-sm btn-secondary grid-transform-link" 
                    data-transform_search="'.e(json_encode($ResultTable->GridSearch->gridSearchForm['data'])).'"
                    data-href="'.route('tokuisaki.edit', ['tokCd'=>$item->tok_cd, 'tokCd2'=>$item->tok_cd2]).'">詳細</button>';
            },
            'attrTd' => 'class="text-nowrap text-center"'
        ],
    ],
    '参照作成' => [
        'active' => 1,
        'skipOrderBy' => true,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => "tok_cd",
            'operator' => '=',
            'value' => null,
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => '参照作成',
            'inner' => function($item, $key, $loop, $ResultTable) {
                return '<a class="btn btn-sm btn-warning grid-transform-link" 
                    data-transform_search="'.e(json_encode($ResultTable->GridSearch->gridSearchForm['data'])).'"
                    data-href="'.route('tokuisaki.copy', ['tokCd'=>$item->tok_cd, 'tokCd2'=>$item->tok_cd2]).'">参照作成</button>';
            },
            'attrTd' => 'class="text-nowrap text-center"'
        ],
    ],
    'tok_cd' => [
        'active' => 1,
        //'skipOrderBy' => true,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => "tok_cd",
            'operator' => 'like',
            'value' => '%{param}%',
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => trans('attributes.m_tokuisaki.tok_cd'),
            'attrTd' => 'class="text-center"'
        ],
    ],
    'tok_nm' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'tok_nm',
            'operator' => 'like',
            'value' => '%{param}%',
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => trans('attributes.m_tokuisaki.tok_nm'),
        ],
    ],
    'shimuke_saki' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'shimuke_saki',
            'operator' => '=',
            'value' => null,
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => '仕向先',
        ],
    ],
    'tok_nm2' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'tok_nm2',
            'operator' => '=',
            'value' => null,
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => trans('attributes.m_tokuisaki.tok_nm2'),
        ],
    ],
    'tel_no' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'tel_no',
            'operator' => '=',
            'value' => null,
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => trans('attributes.m_tokuisaki.tel_no'),
        ],
    ],
    'fax_no' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'fax_no',
            'operator' => '=',
            'value' => null,
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => trans('attributes.m_tokuisaki.fax_no'),
        ],
    ],
    'yubin_no' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'yubin_no',
            'operator' => '=',
            'value' => null,
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => trans('attributes.m_tokuisaki.yubin_no'),
        ],
    ],
    'adr_ken' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'adr_ken',
            'operator' => '=',
            'value' => null,
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => trans('attributes.m_tokuisaki.adr_ken'),
        ],
    ],
    'adr_si' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'adr_si',
            'operator' => '=',
            'value' => null,
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => trans('attributes.m_tokuisaki.adr_si'),
        ],
    ],
    'adr_tyo' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'adr_tyo',
            'operator' => '=',
            'value' => null,
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => trans('attributes.m_tokuisaki.adr_tyo'),
        ],
    ],
    'adr_ban' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'adr_ban',
            'operator' => '=',
            'value' => null,
            'boolean' => null
        ],
        //grid-column
        'grid' => [
            'header' => trans('attributes.m_tokuisaki.adr_ban'),
        ],
    ],
];
