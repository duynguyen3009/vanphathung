<?php
$constants = [
    //https://www.postgresql.org/docs/14/datatype-numeric.html
    'DB_INT_SIGNED_MIN' => -2147483648,
    'DB_INT_SIGNED_MAX' => 2147483647,
];
return array_merge($constants, [
    'perPageOptions' => [
        50 => 50,
    ],
    'options' => [
        'm_tokuisaki' => [
            'tnkg_cd' => [
                'A' => 'A',
                'B' => 'B',
                'C' => 'C',
                'D' => 'D',
            ],
            'oem_taisyo_flg' => [
                1 => 'OEM対象',
                0 => 'OEM対象外',
            ],
            'ksjig_cd' => [
                400 => '住宅',
                500 => '汎用 等'
            ],
            'shukka_meisaisho_kbn' => [
                0 => '出力対象外',
                1 => 'E-FAX'
            ],
            'nifuda_hidden_flg' => [
                1 => '非表示',
                0 => '表示'
            ],
            'not_uriage_flg' => [
                1 => '売上対象外',
                0 => '売上対象'
            ],
            'hyouji_flg' => [
                1 => '無効',
                0 => '有効'
            ],
            'yoshin_gen_kanri_flg' => [
                1 => 'YES',
                0 => 'NO'
            ]
        ],
        'm_tok_kanren' => [
            'sousai_flg' => [
                1 => '相殺対象',
                0 => '相殺対象外',
            ]
        ]
    ]
]);
