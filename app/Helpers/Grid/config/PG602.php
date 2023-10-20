<?php
return [
    '削除' => [
        'active' => 1,
        'skipOrderBy' => true,
        'grid' => [
            'header' => '削除',
            'inner' => function ($item, $key, $loop, $ResultTable) {
                return '<a class="btn btn-sm btn-secondary" id="btn-set-delete-flg-' . $item->key . '"
                onclick="setEditFlg(\'' . $item->key . '\')">削除</a>';
            },
            'attrTh' => 'class="text-center wd-80"'
        ],
    ],
    '修正' => [
        'active' => 1,
        'skipOrderBy' => true,
        'grid' => [
            'header' => '修正',
            'inner' => function ($item, $key, $loop, $ResultTable) {
                return '<a class="btn btn-sm btn-secondary" id="btn-edit-tok-kanren-' . $item->key . '"
                onclick="editTokKanren(\'' . $item->key  . '\')">修正</a>';
            },
            'attrTh' => 'class="text-center wd-80"'
        ],
    ],
    'user_tok_cd' => [
        'active' => 1,
        'skipOrderBy' => true,
        'params' => [
            'column' => 'user_tok_cd',
        ],
        'grid' => [
            'header' => trans('attributes.m_tok_kanren.user_tok_cd'),
            'attrTh' => 'class="text-center" style="width:27%"',
        ],
    ],
    'tok_nm' => [
        'active' => 1,
        'skipOrderBy' => true,
        'params' => [
            'column' => 'tok_nm',
        ],
        'grid' => [
            'header' => trans('attributes.m_tokuisaki.tok_nm'),
            'attrTh' => 'style="width:27%"',
        ],
    ],
    'sousai_flg' => [
        'active' => 1,
        'skipOrderBy' => true,
        'params' => [
            'column' => 'sousai_flg',
        ],
        'grid' => [
            'header' => trans('attributes.m_tok_kanren.sousai_flg'),
            'attrTh' => 'style="width:27%"',
            'inner' => function ($item, $key, $loop, $ResultTable) {
                $attributes = new Illuminate\View\ComponentAttributeBag();
                $attributes->setAttributes([
                    'class' => 'form-control d-none',
                    'name' =>  $key . '-' . $item->key,
                ]);
                $view = view('components.select', [
                    'list' => config('params.options.m_tok_kanren.sousai_flg'),
                    'data' => (int) $item->{$key},
                    'slot' => '<option value="">選択</option>',
                    'attributes' => $attributes,
                ]);
                $errSpan = '<span class="text-danger" id="error' . $key . '-' . $item->key . '">';
                return '<span id="' . $key . '-' . $item->key . '">' . config('params.options.m_tok_kanren.sousai_flg')[(int)$item->{$key}] . '</span>' . $view . $errSpan;
            },
        ],
    ],
    'form' => [
        'active' => 0,
        'tok_cd' => [
            'attrInput' => 'maxlength = 8',
            'classCustom' => 'col-sm-4',
            'required' => true,
            'default' => '',
        ],
        'tok_nm' => [
            'attrInput' => 'maxlength = 20',
            'classCustom' => 'col-sm-8',
            'default' => '',
        ],
        'tok_nm2' => [
            'attrInput' => 'maxlength = 20',
            'classCustom' => 'col-sm-7',
            'default' => '',
        ],
        'tok_ryaku_nm' => [
            'attrInput' => 'maxlength = 10',
            'classCustom' => 'col-sm-8',
            'required' => true,
            'default' => '',
        ],
        'tel_no' => [
            'attrInput' => 'maxlength = 15',
            'classCustom' => 'col-sm-7',
            'default' => '',
        ],
        'tok_kana_ryaku_nm' => [
            'attrInput' => 'maxlength = 20',
            'classCustom' => 'col-sm-8',
            'required' => true,
            'default' => '',
        ],
        'tel_no' => [
            'attrInput' => 'maxlength = 15',
            'classCustom' => 'col-sm-7',
            'default' => '',
        ],
        'tok_kana_ryaku_nm' => [
            'attrInput' => 'maxlength = 20',
            'classCustom' => 'col-sm-8',
            'required' => true,
            'default' => '',
        ],
        'fax_no' => [
            'attrInput' => 'maxlength = 15',
            'classCustom' => 'col-sm-7',
            'default' => '',
        ],
        'yubin_no' => [
            'attrInput' => 'maxlength = 7',
            'classCustom' => 'col-sm-4',
            'default' => '',
            'slot' =>  "<div class='col-sm-4 form-group'>
                            <button class='btn-secondary' type='button' onclick='setValueAdr(this)'>〒 → 住所</button>
                            </div>"
        ],
        'houjin_cd' => [
            'attrInput' => 'maxlength = 13',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'adr_ken' => [
            'attrInput' => 'readonly maxlength = 4',
            'type' => 'input',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'jyu_fax_no' => [
            'attrInput' => 'maxlength = 15',
            'classCustom' => 'col-sm-7',
            'default' => '',
        ],
        'adr_si' => [
            'attrInput' => 'readonly maxlength = 10',
            'classCustom' => 'col-sm-8',
            'type' => 'input',
            'default' => '',
        ],
        'jyu_fax_mail_adr' => [
            'attrInput' => 'maxlength = 50',
            'classCustom' => 'col-sm-7',
            'type' => 'email',
            'default' => '',
        ],
        'adr_tyo' => [
            'attrInput' => 'maxlength = 20',
            'classCustom' => 'col-sm-8',
            'required' => true,
            'default' => '',
        ],
        'jyu_mail_adr' => [
            'attrInput' => 'maxlength = 50',
            'classCustom' => 'col-sm-7',
            'type' => 'email',
            'default' => '',
        ],
        'adr_ban' => [
            'attrInput' => 'maxlength = 20',
            'classCustom' => 'col-sm-8',
            'default' => '',
        ],
        'cellmail_adr' => [
            'attrInput' => 'maxlength = 50',
            'classCustom' => 'col-sm-7',
            'type' => 'email',
            'default' => '',
        ],
        'cdr_cd' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-4',
            'type' => 'select',
            'default' => '',
        ],
        'saiken_keijo_saki_tok_cd' => [],
        'tnkg_cd' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-4',
            'default' => '',
            'required' => true,
            'type' => 'select',
        ],
        'saiken_keijo_saki_tok_cd2' => [
            'attrInput' => 'readonly',
            'classCustom' => 'col-sm-4',
            'type' => '',
            'default' => '',
            'slot' => "<div class='col-sm-4 form-group'>
                            <label class='label-secondary' id='label-saiken_keijo_saki_tok_cd2'></label>
                            </div>"
        ],
        'a_cd' => [
            'attrInput' => 'maxlength = 10',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'tok_kbn' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-5',
            'type' => 'select',
            'required' => true,
            'default' => '',
        ],
        'b_cd' => [
            'attrInput' => 'maxlength = 10',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'tok_shubetsu' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-5',
            'type' => 'select',
            'required' => true,
            'default' => '',
        ],
        'c_cd' => [
            'attrInput' => 'maxlength = 10',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'untin_kbn' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-5',
            'type' => 'select',
            'required' => true,
            'default' => '',
        ],
        'd_cd' => [
            'attrInput' => 'maxlength = 10',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'untin_pattern' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-5',
            'type' => 'select',
            'default' => '',
        ],
        'e_cd' => [
            'attrInput' => 'maxlength = 10',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'oem_taisyo_flg' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-5',
            'type' => 'select',
            'required' => true,
            'default' => '',
        ],
        'tk_cd' => [
            'attrInput' => 'maxlength = 10',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'disp_ctrl_oem' => [
            'attrInput' => 'maxlength = 3',
            'classCustom' => 'col-sm-3',
            'default' => '',
        ],
        'uke_busho_cd' => [
            'attrInput' => 'setFieldNm(this)',
            'classCustom' => 'col-sm-4',
            'type' => 'select',
            'default' => '',
            'slot' => "<div class='col-sm-4 form-group'>
                    <label class='label-secondary' id='label-uke_busho_cd'></label>
                    </div>"
        ],
        'ksjig_cd' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-5',
            'required' => true,
            'default' => '',
            'type' => 'select',
        ],
        'uke_tan_cd' => [
            'attrInput' => 'setFieldNm(this)',
            'classCustom' => 'col-sm-4',
            'type' => 'select',
            'default' => '',
            'slot' => "<div class='col-sm-4 form-group'>
                    <label class='label-secondary' id='label-uke_tan_cd'></label>
                    </div>"
        ],
        'hai_group_cd_1' => [
            'attrInput' => 'maxlength = 10',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'eig_busho_cd' => [
            'attrInput' => 'setFieldNm(this)',
            'classCustom' => 'col-sm-4',
            'type' => 'select',
            'default' => '',
            'required' => true,
            'slot' => "<div class='col-sm-4 form-group'>
                    <label class='label-secondary' id='label-eig_busho_cd'></label>
                    </div>"
        ],
        'hai_group_cd_2' => [
            'attrInput' => 'maxlength = 10',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'eig_tan_cd' => [
            'attrInput' => 'setFieldNm(this)',
            'classCustom' => 'col-sm-4',
            'default' => '',
            'required' => true,
            'type' => 'select',
            'slot' => "<div class='col-sm-4 form-group'>
                    <label class='label-secondary' id='label-eig_tan_cd'></label>
                    </div>"
        ],
        'endhat_dt' => [
            'attrInput' => 'maxlength = 10',
            'classCustom' => 'col-sm-4',
            'type' => 'date',
            'default' => '',
        ],
        'hyouji_flg01' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-4',
            'required' => true,
            'type' => 'select',
            'default' => 0,
        ],
        'shukka_meisaisho_kbn' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-5',
            'required' => true,
            'type' => 'select',
            'default' => '',
        ],
        'hyouji_flg02' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-4',
            'required' => true,
            'type' => 'select',
            'default' => 0,
        ],
        'yoshin_gendo_amount' => [
            'attrInput' => 'maxlength = 9',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'hyouji_flg03' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-4',
            'required' => true,
            'type' => 'select',
            'default' => 0,
        ],
        'yoshin_gen_kanri_flg' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-4',
            'type' => 'select',
            'default' => '',
        ],
        'hyouji_flg04' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-4',
            'required' => true,
            'type' => 'select',
            'default' => 0,
        ],
        'jigyosho_num' => [
            'attrInput' => 'maxlength = 14',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'hyouji_flg05' => [
            'attrInput' => 'maxlength = 10',
            'classCustom' => 'col-sm-4',
            'required' => true,
            'type' => 'select',
            'default' => 0,
        ],
        'nifuda_hin_nm_hidden_flg' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-5',
            'type' => 'select',
            'default' => 0,
            'required' => true,
        ],
        'hyouji_flg06' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-4',
            'type' => 'select',
            'required' => true,
            'default' => 0,
        ],
        'nifuda_sikityo_hidden_flg' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-5',
            'type' => 'select',
            'required' => true,
            'default' => 0,
        ],
        'hyouji_flg07' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-4',
            'required' => true,
            'type' => 'select',
            'default' => 0,
        ],
        'not_uriage_flg' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-5',
            'type' => 'select',
            'required' => true,
            'default' => 0,
        ],
        'hyouji_flg08' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-4',
            'type' => 'select',
            'required' => true,
            'default' => 0,
        ],
        'mihon_label_kbn' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-5',
            'type' => 'select',
            'default' => 0,
        ],
        'hyouji_flg09' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-4',
            'type' => 'select',
            'required' => true,
            'default' => 0,
        ],
        'col' => [
            'active' => 0
        ],
        'hyouji_flg10' => [
            'attrInput' => '',
            'classCustom' => 'col-sm-4',
            'type' => 'select',
            'required' => true,
            'default' => 0,
        ],
        'col1' => [
            'active' => 0
        ],
        'tok_g1' => [
            'attrInput' => 'maxlength = 7',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'col2' => [
            'active' => 0
        ],
        'tok_g2' => [
            'attrInput' => 'maxlength = 7',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
        'col3' => [
            'active' => 0
        ],
        'tok_g3' => [
            'attrInput' => 'maxlength = 7',
            'classCustom' => 'col-sm-4',
            'default' => '',
        ],
    ]
];
