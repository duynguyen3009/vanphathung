<?php
return [
    'action' => [
        'active' => 1,
        'skipOrderBy' => true,
        'mapping' => false,
        'grid' => [
            'header' => '詳細',
            'attrTd' => 'class="text-center"',
            'inner' => function($item, $key, $loop, $ResultTable) {
                return '<a class="btn btn-sm btn-secondary" 
                    data-transform_search="'.e(json_encode($ResultTable->GridSearch->gridSearchForm['data'])).'"
                    data-href="'.route('haigo_key_mei.edit', ['haigoKey' => $item->haigo_key, 'hinCd' => $item->hin_cd, 'kikakuCd' => $item->kikaku_cd]).'"
                    data-record="'. e(json_encode(collect($item)->only(['hin_cd', 'kikaku_cd']))).'"
                    onclick="redirect(this, \'edit\')"
                    >詳細</a>';
            },
        ],
    ],
    'hin_cd' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'hin_cd',
        ],
        //grid-column
        'grid' => [
            'header' => '品目コード',
            'attrTd' => 'class="text-center"',
        ],
    ],
    'hin_nm' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'hin_nm',
        ],
        //grid-column
        'grid' => [
            'header' => '品名',
        ],
    ],
    'kikaku_cd' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'kikaku_cd',
        ],
        //grid-column
        'grid' => [
            'header' => '規格コード',
            'attrTd' => 'class="text-center"',
        ],
    ],
    'kikaku' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'kikaku',
        ],
        //grid-column
        'grid' => [
            'header' => '規格',
        ],
    ],
    'ganryo_kbn' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'ganryo_kbn',
        ],
        //grid-column
        'grid' => [
            'header' => '顔料区分',
        ],
    ],
    'bihikuru_keisu' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'bihikuru_keisu',
        ],
        //grid-column
        'grid' => [
            'header' => 'ビヒクル係数',
            'attrTd' => 'class="text-right"',
            'inner' => function($item, $key, $loop, $ResultTable) {
                return e(\App\Helpers\Formatter::number($item->$key));
            },
        ],
    ],
    'tonyu_group_no' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'tonyu_group_no',
        ],
        //grid-column
        'grid' => [
            'header' => '投入グループ番号',
            'attrTd' => 'class="text-right"',
        ],
    ],
    'disp_jun' => [
        'active' => 1,
        //query-builder
        'method' => 'where',
        'params' => [
            'column' => 'disp_jun',
        ],
        //grid-column
        'grid' => [
            'header' => '投入順',
            'attrTd' => 'class="text-right"',
        ],
    ],
];