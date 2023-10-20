<?php
return [
    'kikaku_cd' => [
        'active' => 1,
        'skipOrderBy' => true,
        'params' => [
            'column' => 'kikaku_cd',
        ],
        'grid' => [
            'header' => '規格コード',
        ],
    ],
    'tk19_name' => [
        'active' => 1,
        'skipOrderBy' => true,
        'params' => [
            'column' => 'tk19_name',
        ],
        'grid' => [
            'header' => '艶区分',
        ],
    ],
    't112_name' => [
        'active' => 1,
        'skipOrderBy' => true,
        'params' => [
            'column' => 't112_name',
        ],
        'grid' => [
            'header' => '入目',
            'attrTd' => 'class="text-right"',
        ],
    ],
    'tk17_name' => [
        'active' => 1,
        'skipOrderBy' => true,
        'params' => [
            'column' => 'tk17_name',
        ],
        'grid' => [
            'header' => '入目単位区分',
        ],
    ],
    't113_name' => [
        'active' => 1,
        'skipOrderBy' => true,
        'params' => [
            'column' => 't113_name',
        ],
        'grid' => [
            'header' => 'サイズ区分',
        ],
    ],
    't114_name' => [
        'active' => 1,
        'skipOrderBy' => true,
        'params' => [
            'column' => 't114_name',
        ],
        'grid' => [
            'header' => '形状区分',
        ],
    ],
    't115_name' => [
        'active' => 1,
        'skipOrderBy' => true,
        'params' => [
            'column' => 't115_name',
        ],
        'grid' => [
            'header' => '目地区分',
        ],
    ],
   
    'jyu_entry_fuka_flg' => [
        'active' => 1,
        'skipOrderBy' => true,
        'params' => [
            'column' => 'selectbox',
        ],
        'grid' => [
            'header' => '受注入力不可フラグ',
            'inner' => function ($item, $key, $loop, $ResultTable) {
                $keyRow = $item->hin_cd . '_' . $item->kikaku_cd . '_' . $item->ktn_cd;
                $attributes = new Illuminate\View\ComponentAttributeBag();
                $attributes->setAttributes([
                    'class' => 'form-control',
                    'name' => 'jyu_entry_fuka_flg__' . $keyRow,
                    
                ]);
                $view = view('components.select', [
                    'list' => config('params.options.m_hanbai_kojo_hinmoku.jyu_entry_fuka_flg'),
                    'data' => $item->jyu_entry_fuka_flg,
                    'slot' => '',
                    'attributes' => $attributes,
                ]);
                $lblErr = '<label class="text-danger msg-error" for="jyu_entry_fuka_flg__'.$keyRow.'"></label>';
                return  $view . $lblErr;
            },
        ],
    ],

    'button' => [
        'active' => 1,
        'skipOrderBy' => true,
        'grid' => [
            'header' => '更新',
            'inner' => function ($item, $key, $loop, $ResultTable) {
                $keyRow = $item->hin_cd . '_' . $item->kikaku_cd . '_' . $item->ktn_cd;
                return '<a class="btn btn-sm btn-secondary" 
                            data-hin_cd="'.$item->hin_cd.'"
                            data-kikaku_cd="'.$item->kikaku_cd.'"
                            data-ktn_cd="'.$item->ktn_cd.'"
                            data-href="'.route('pg202.save_hanbai_kojo').'"
                            data-key_row = "'.$keyRow.'"
                            onclick="saveHanbaiKojo(this)">
                削除</a>';
            },
            'attrTh' => 'class="text-center wd-80"'
        ],
    ],
  
];
