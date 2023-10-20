<?php
return [
    //title
    'title' => [
        'menu' => 'マスタメニュー',

        // 1**
        'hinmoku' => [
            'index' => '品目マスタメンテ',
        ],

        // 2**
        'hanbai_kojo_hinmoku' => [
            'index' => '販売工場別品目マスタメンテ'
        ],

        // 3**
        'ganryo_pump' => [
            'index'     => '顔料ポンプマスタメンテ',
            'create'    => '顔料ポンプマスタメンテ　詳細画面',
            'edit'      => '顔料ポンプマスタメンテ　詳細画面',
            'copy'      => '顔料ポンプマスタメンテ　詳細画面',
        ],

        // 4**
        'haigo_key' => [
            'index'     => '配合キーマスタメンテ',
            'create'    => '配合キーマスタメンテ　詳細画面',
            'edit'      => '配合キーマスタメンテ　詳細画面',
            'copy'      => '配合キーマスタメンテ　詳細画面',
        ],
        'haigo_key_mei' => [
            'index' => '配合キー明細',
            'create' => '配合キーマスタメンテ　配合キー明細画面',
            'edit' => '配合キーマスタメンテ　配合キー明細画面'
        ],

        // 5**
        'shiire' =>  [
            'index' => '仕入先マスタメンテ',
            'create' => '仕入先マスタメンテ　詳細画面',
            'edit' => '仕入先マスタメンテ　詳細画面'
        ],

        // 6**
        'tokuisaki' => [
            'index' => '得意先マスタメンテ',
            'create' => '得意先マスタメンテ',
            'copy' => '得意先マスタメンテ',
            'edit' => '得意先マスタメンテ',
        ],
    ],

    // selectbox
    'init_selection' => [
        'all'       => '全て',
        'option'    => '選択',
    ],

    // label
    'labels' => [
        'Error' => 'エラー',
    ],
];
