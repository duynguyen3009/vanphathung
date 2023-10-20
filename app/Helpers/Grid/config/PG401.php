<?php
return [
    'btn-detail' => [
        'active' => 1,
        'skipOrderBy' => true,
        'method' => 'where',
        'grid' => [
            'header' => '詳細',
            'inner' => function ($item, $key, $loop, $ResultTable) {
                return '<a class="btn btn-sm btn-secondary grid-transform-link" 
                data-transform_search="' . e(json_encode($ResultTable->GridSearch->gridSearchForm['data'])) . '"
                data-href="' . route('haigo_key.edit', ['haigoKey' => $item->haigo_key]) . '">詳細</button>';
            },
            'attrTh' => 'class="wd-80"',
            'attrTd' => 'class="text-center"',
        ],
        'params' => [
            'column' => 'haigo_key'
        ]
    ],
    'btn-create-reference' => [
        'active' => 1,
        'skipOrderBy' => true,
        'grid' => [
            'header' => '参照作成',
            'inner' => function ($item, $key, $loop, $ResultTable) {
                return '<a class="btn btn-sm btn-warning grid-transform-link" 
                data-transform_search="' . e(json_encode($ResultTable->GridSearch->gridSearchForm['data'])) . '"
                data-href="' . route('haigo_key.copy', ['haigoKey' => $item->haigo_key]) . '">参照作成</button>';
            },
            'attrTh' => 'class="wd-120"',
            'attrTd' => 'class="text-center"',
        ]

    ],
    'haigo_key' => [
        'active' => 1,
        'method' => 'where',
        'grid' => [
            'header' => trans('attributes.m_haigo_key.haigo_key'),
            'attrTd' => 'class="text-center"',
        ],
        'params' => [
            'column' => 'haigo_key',
            'operator' => 'like',
            'value' => '%{param}%',
            'boolean' => null,
        ]
    ],
    'haigo_key_nm' => [
        'active' => 1,
        'method' => 'where',
        'grid' => [
            'header' => trans('attributes.m_haigo_key.haigo_key_nm'),
        ],
        'params' => [
            'column' => 'haigo_key_nm',
            'operator' => 'like',
            'value' => '%{param}%',
            'boolean' => null,
        ]
    ],
    'name' => [
        'active' => 1,
        'method' => 'where',
        'selectOpt' => true,
        'grid' => [
            'header' => trans('attributes.m_haigo_key.seihin_kbn'),
        ],
        'params' => [
            'column' => 'name',
            'operator' => null,
            'closure' => function ($query, $v) {
                return $query->where('seihin_kbn', $v);
            },
            'value' => '%{param}%',
            'boolean' => null,
        ]
    ],
    'flat_base_keisu' => [
        'active' => 1,
        'grid' => [
            'header' => trans('attributes.m_haigo_key.flat_base_keisu'),
            'attrTd' => 'class="text-right"',
            'inner' => function ($item, $key, $loop, $ResultTable) {
                return \App\Helpers\Formatter::number($item->$key);
            }
        ],
        'params' => [
            'column' => 'flat_base_keisu'
        ]
    ]
];
