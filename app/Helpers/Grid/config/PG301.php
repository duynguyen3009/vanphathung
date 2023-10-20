<?php

return [
    'btn-detail' => [
        'active' => 1,
        'skipOrderBy' => true,
        'method' => 'where',
        'grid' => [
            'header' => '詳細',
            'attrTd' => 'class="text-center"',
            'inner' => function ($item, $key, $loop, $ResultTable) {
                return '<a class="btn btn-sm btn-secondary" 
                        data-transform_search="'.e(json_encode($ResultTable->GridSearch->gridSearchForm['data'])).'"
                        data-href="'.route('ganryo_pump.edit', [
                            'ktnCd' => $item->ktn_cd,
                            'hinCd' => $item->hin_cd,
                            'kikakuCd' => $item->kikaku_cd,
                            'dispenserKbn' => $item->dispenser_kbn,
                        ]).'" 
                        data-record="'. e(json_encode(collect($item)->only(['ktn_cd', 'hin_cd', 'kikaku_cd', 'dispenser_kbn']))).'"
                        onclick="redirect(this)"
                        >詳細</a>';
            }
            
        ],
        'params' => [
            'column' => 'ktn_cd'
        ]
    ],
    'btn-create-reference' => [
        'active' => 1,
        'skipOrderBy' => true,
        'grid' => [
            'header' => '参照作成',
            'attrTd' => 'class="text-center"',
            'inner' => function ($item, $key, $loop, $ResultTable) {
                return '<a class="btn btn-sm btn-warning" 
                        data-transform_search="'.e(json_encode($ResultTable->GridSearch->gridSearchForm['data'])).'"
                        data-href="'.route('ganryo_pump.copy', [
                            'ktnCd' => $item->ktn_cd,
                            'hinCd' => $item->hin_cd,
                            'kikakuCd' => $item->kikaku_cd,
                            'dispenserKbn' => $item->dispenser_kbn,
                        ]).'" 
                        data-record="'. e(json_encode(collect($item)->only(['ktn_cd', 'hin_cd', 'kikaku_cd', 'dispenser_kbn']))).'"
                        onclick="redirect(this)"
                        >参照作成</a>';
            }
        ]

    ],
    'ktn_cd' => [
        'active' => 1,
        'method' => 'where',
        'grid' => [
            'header' => '拠点コード',
            'attrTd' => 'class="text-center"',
        ],
        'params' => [
            'column' => 'ktn_cd',
            'operator' => null,
            'value' => null,
            'boolean' => null,
            'closure' => function(&$query, $value) {
                $query->where('m_ganryo_pump.ktn_cd', 'like', "%{$value}%");
            },
        ]
    ],
    'hin_cd' => [
        'active' => 1,
        'method' => 'where',
        'grid' => [
            'header' => '品目コード',
        ],
        'params' => [
            'column' => 'hin_cd',
            'operator' => null,
            'value' => null,
            'boolean' => null,
            'closure' => function(&$query, $value) {
                $query->where('m_ganryo_pump.hin_cd', 'like', "%{$value}%");
            },
        ]
        
    ],
    'hin_nm' => [
        'active' => 1,
        'method' => 'where',
        'grid' => [
            'header' => '品目名称',
        ],
        'params' => [
            'column' => 'hin_nm',
            'operator' => null,
            'value' => null,
            'boolean' => null,
            'closure' => function(&$query, $value) {
                $query->where('m_hinmoku.hin_nm', 'like', "%{$value}%");
            },
        ]
    ],
    'kikaku_cd' => [
        'active' => 1,
        'method' => 'where',
        'grid' => [
            'header' => '規格コード',
        ],
        'params' => [
            'column' => 'kikaku_cd',
            'operator' => null,
            'value' => null,
            'boolean' => null,
            'closure' => function(&$query, $value) {
                $query->where('m_ganryo_pump.kikaku_cd', 'like', "%{$value}%");
            },
        ]
    ],
    'name' => [
        'active' => 1,
        'method' => 'where',
        'grid' => [
            'header' => '規格',
        ],
        'params' => [
            'column' => 'name',
        ]
    ],
    'dispenser_kbn' => [
        'active' => 1,
        'method' => 'where',
        'grid' => [
            'header' => 'ディスペンサー区分',
        ],
        'params' => [
            'column' => 'dispenser_kbn',
        ]
    ],
    'lot_no' => [
        'active' => 1,
        'method' => 'where',
        'grid' => [
            'header' => 'ロットNo.',
        ],
        'params' => [
            'column' => 'lot_no',
        ]
    ],
    'keisu' => [
        'active' => 1,
        'method' => 'where',
        'grid' => [
            'header' => '顔料係数',
        ],
        'params' => [
            'column' => 'keisu',
        ]
    ],
];
