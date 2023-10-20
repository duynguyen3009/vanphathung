<?php
return [
    'btn-copy' => [
        'active' => 1,
        'skipOrderBy' => true,
        'grid' => [
            'header' => '参照作成',
            'inner' => function ($item, $key, $loop, $ResultTable) {
                return '<a class="btn btn-sm btn-warning grid-transform-link" 
                data-transform_search="' . e(json_encode($ResultTable->GridSearch->gridSearchForm['data'])) . '"
                data-href="' . route('hinmoku.copy', ['hinCd' => $item->hin_cd]) . '">参照作成</button>';
            },
            'attrTh' => 'class="wd-120"',
            'attrTd' => 'class="text-center"',
        ],
        'params' => [
            'column' => 'hin_cd'
        ]
    ],
    'name' => [
        'active' => 1,
        'method' => 'where',
        'selectOpt' => true,
        'grid' => [
            'header' => trans('attributes.m_hinmoku.hin_kbn'),
            'attrTd' => 'class="text-center"',
        ],
        'params' => [
            'column' => 'name',
            'operator' => null,
            'closure' => function ($query, $v) {
                return $query->where('hin_kbn', $v);
            },
            'value' => '%{param}%',
            'boolean' => null,
        ]
    ],
    'hin_cd' => [
        'active' => 1,
        'method' => 'where',
        'grid' => [
            'header' => trans('attributes.m_hinmoku.hin_cd'),
            'attrTd' => 'class="text-center"',
        ],
        'params' => [
            'column' => 'hin_cd',
            'operator' => 'like',
            'value' => '%{param}%',
            'boolean' => null,
        ]
    ],
    'hin_nm' => [
        'active' => 1,
        'method' => 'where',
        'grid' => [
            'header' => trans('attributes.m_hinmoku.hin_nm'),
        ],
        'params' => [
            'column' => 'hin_nm',
            'operator' => 'like',
            'value' => '%{param}%',
            'boolean' => null,
        ]
    ],
    'upd_dt' => [
        'active' => 1,
        'grid' => [
            'header' => trans('attributes.m_hinmoku.upd_dt'),
            'inner' => function ($item, $key, $loop, $ResultTable) {
                return \App\Helpers\Formatter::date($item->$key);
            },
        ],
        'params' => [
            'column' => 'upd_dt'
        ]
    ],
    'user_nm' => [
        'active' => 1,
        'grid' => [
            'header' => trans('attributes.m_user.user_nm'),
        ],
        'params' => [
            'column' => 'user_nm'
        ]
    ]
];
