<?php
    return [
        'shiire_cd' => [
            'label' => '仕入先コード',
            'type' => 'textbox',
            'require' => true,
            'options' => [],
            'value' => ''
        ],
        'shiire_nm2' => [
            'label' => '仕入先営業所名',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'tel_no' => [
            'label' => '電話番号',
            'type' => 'textbox',
            'require' => true,
            'options' => [],
            'value' => ''
        ],
        'fax_no' => [
            'label' => 'FAX番号',
            'type' => 'textbox',
            'require' => true,
            'options' => [],
            'value' => ''
        ],
        'hatchu_fax_send_flg' => [
            'label' => '発注時FAX送信フラグ',
            'type' => 'selectbox',
            'require' => true,
            'options' => [
                '0' => '発注書出力（紙）',
                '1' => '発注書出力時自動FAX送信',
            ],
            'selected' => '0'
        ],
        'jyu_fax_no' => [
            'label' => '受注FAX番号',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'jyu_mail_adr' => [
            'label' => '受注メールアドレス',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'cellmail_adr' => [
            'label' => '携帯メールアドレス',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'tan_nm' => [
            'label' => '顧客責任者',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'uke_busho_cd' => [
            'label' => 'KS受付部署CD',
            'type' => 'selectbox',
            'require' => false,
            'options' => [],
            'value' => '',
            'children' => [
                'type' => 'input',
                'name' => 'uke_busho_nm',
                'label' => '',
                'value' => ''
            ]
        ],
        'uke_tan_cd' => [
            'label' => 'KS受付社員番号',
            'type' => 'selectbox',
            'require' => false,
            'options' => [],
            'value' => '',
            'children' => [
                'type' => 'input',
                'name' => 'uke_tan_cd_nm',
                'label' => '',
                'value' => ''
            ]
        ],
        'sime_tm' => [
            'label' => '締切時間',
            'type' => 'textbox',
            'require' => true,
            'options' => [],
            'value' => ''
        ],
        'shitaukeho_note' => [
            'label' => '下請法コメント',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'kenshuhokokusho_fax_send_kyoka' => [
            'label' => '検収報告書FAX送信許可',
            'type' => 'selectbox',
            'require' => true,
            'options' => [
                '0' => '何もしない',
                '1' => 'FAX送信対象',
            ],
            'selected' => '0'
        ],
        'sizaibu_flg' => [
            'label' => '資材部フラグ',
            'type' => 'selectbox',
            'require' => false,
            'options' => [
                '0' => '0',
                '1' => '1'
            ],
            'value' => '',
            'selected' => '0'
        ],
        'hatchu_mail_adr' => [
            'label' => '発注メールアドレス',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'kenshusho_send_flg' => [
            'label' => '検収報告書送付先フラグ',
            'type' => 'selectbox',
            'require' => true,
            'options' => [
                '0' => '0',
                '1' => '1'
            ],
            'value' => '',
            'selected' => '0'
        ],
        'shiire_g2' => [
            'label' => '仕入先G2',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'm_koza_id' => [
            'label' => '口座マスタID',
            'type' => 'selectbox',
            'require' => false,
            'options' => [],
            'value' => '',
            'selected' => '0'
        ],
        'kinyu_nm' => [
            'label' => '金融機関名',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'koza_type' => [
            'label' => '口座種類',
            'type' => 'selectbox',
            'require' => false,
            'options' => [],
            'value' => '',
            'selected' => '0'
        ],
        'koza_meigi' => [
            'label' => '口座名義',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'shiire_nm' => [
            'label' => '仕入先名',
            'type' => 'textbox',
            'require' => true,
            'options' => [],
            'value' => ''
        ],
        'shiire_ryaku_nm' => [
            'label' => '仕入先略称',
            'type' => 'textbox',
            'require' => true,
            'options' => [],
            'value' => ''
        ],
        'shiire_kana_ryaku_nm' => [
            'label' => '仕入先カナ略名',
            'type' => 'textbox',
            'require' => true,
            'options' => [],
            'value' => ''
        ],
        'yubin_no' => [
            'label' => '郵便番号',
            'type' => 'textbox',
            'require' => true,
            'options' => [],
            'value' => '',
            'children' => [
                'type' => 'button',
                'name' => 'juusho',
                'label' => '',
                'value' => ''
            ]
        ],
        'adr_ken' => [
            'label' => '都道府県',
            'type' => 'label',
            'require' => true,
            'options' => [],
            'value' => ''
        ],
        'adr_si' => [
            'label' => '市区町村',
            'type' => 'label',
            'require' => true,
            'options' => [],
            'value' => ''
        ],
        'adr_tyo' => [
            'label' => '住所1',
            'type' => 'label',
            'require' => true,
            'options' => [],
            'value' => ''
        ],
        'adr_ban' => [
            'label' => '住所2',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'adr_bil' => [
            'label' => '建物',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'shiire_kbn' => [
            'label' => '仕入先区分',
            'type' => 'selectbox',
            'require' => true,
            'options' => [],
            'value' => '',
            'selected' => '0'
        ],
        'eig_tan_cd' => [
            'label' => 'KS営業社員番号',
            'type' => 'selectbox',
            'require' => true,
            'options' => [],
            'value' => '',
            'children' => [
                'type' => 'input',
                'name' => 'eig_tan_cd_nm',
                'label' => '',
                'value' => ''
            ]
        ],
        'eig_busho_cd' => [
            'label' => 'KS営業部署CD',
            'type' => 'selectbox',
            'require' => false,
            'options' => [],
            'value' => '',
            'children' => [
                'type' => 'input',
                'name' => 'eig_busho_nm',
                'label' => '',
                'value' => ''
            ]
        ],
        'ksjig_cd' => [
            'label' => 'KS事業区分',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'saimu_keijo_saki_shiire_cd' => [
            'label' => '債務計上先仕入先CD',
            'type' => 'selectbox',
            'require' => false,
            'options' => [],
            'value' => '',
            'children' => [
                'type' => 'input',
                'name' => 'saimu_keijo_saki_shiire_cd_nm',
                'label' => '',
                'value' => ''
            ],
            'selected' => '0'
        ],
        'saimu_keijo_saki_shiire_cd2' => [
            'label' => '債務計上先仕入先営業所CD',
            'type' => 'label',
            'require' => false,
            'options' => [],
            'value' => '',
            'children' => [
                'type' => 'input',
                'name' => 'saimu_keijo_saki_shiire_c2_nm',
                'label' => '',
                'value' => ''
            ],
            'selected' => '0'
        ],
        'jigyosho_num' => [
            'label' => '事業所番号',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'hatyusho_send_flg' => [
            'label' => '発注書送付先フラグ',
            'type' => 'selectbox',
            'require' => true,
            'options' => [
                '0' => '発注入力時の発注先として入力不可',
                '1' => '発注入力時の発注先として入力可能',
            ],
            'selected' => '0'
        ],
        'shiire_g1' => [
            'label' => '仕入先G1',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'shiire_g3' => [
            'label' => '仕入先G3',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'kinyu_siten_nm' => [
            'label' => '金融機関支店名',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
        'koza_no' => [
            'label' => '口座番号',
            'type' => 'textbox',
            'require' => false,
            'options' => [],
            'value' => ''
        ],
    ];
?>