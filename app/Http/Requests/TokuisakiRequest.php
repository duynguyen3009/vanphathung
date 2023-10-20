<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TokuisakiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $formInputs     = $this->all();

        $rulerequiredMax = 'required|max:7|regex:/^[a-zA-Z0-9]+$/u';

        switch ($formInputs['action']) {
            case 'save':
                $rules = [
                    'tok_cd'         => $rulerequiredMax . '|unique:m_tokuisaki,tok_cd',
                    'tok_nm'      => 'max:20',
                    'tok_nm2'      => 'max:20',
                    'tok_ryaku_nm'      => 'required|max:10',
                    'tel_no'      => 'bail|nullable|max:15|regex:/^[0-9\-]+$/u',
                    'tok_kana_ryaku_nm'      => 'required|max:20',
                    'fax_no'      => 'bail|nullable|max:15|regex:/^[0-9\-]+$/u',
                    'yubin_no'      => 'max:9999999|numeric|nullable',
                    'houjin_cd'      => 'max:13',
                    'jyu_fax_no'      => 'bail|nullable|max:15|regex:/^[0-9\-]+$/u',
                    'jyu_fax_mail_adr'      => 'email|max:50' . $formInputs['shukka_meisaisho_kbn'] == 1 ? 'required' : '',
                    'adr_tyo'      => 'required|max:20',
                    'jyu_mail_adr'      => 'bail|max:50|nullable|email',
                    'adr_ban'      => 'max:20',
                    'cellmail_adr'      => 'bail|max:50|nullable|email',
                    'tnkg_cd'      => 'required',
                    'a_cd'      => 'max:10',
                    'tok_kbn'      => 'required',
                    'b_cd'      => 'max:10',
                    'tok_shubetsu'      => 'required',
                    'c_cd'      => 'max:10',
                    'untin_kbn'      => 'required',
                    'd_cd'      => 'max:10',
                    'e_cd'      => 'max:10',
                    'oem_taisyo_flg'      => 'required',
                    'tk_cd'      => 'max:10',
                    'disp_ctrl_oem'      => 'max:3',
                    'ksjig_cd'      => 'required',
                    'hai_group_cd_1'      => 'max:10',
                    'eig_busho_cd'      => 'required',
                    'hai_group_cd_2'      => 'max:10',
                    'eig_tan_cd'      => 'required',
                    'hyouji_flg01'      => 'required',
                    'shukka_meisaisho_kbn'      => 'required',
                    'hyouji_flg02'      => 'required',
                    'yoshin_gendo_amount'      => 'bail|nullable|max:999999999|numeric',
                    'hyouji_flg03'      => 'required',
                    'hyouji_flg04'      => 'required',
                    'jigyosho_num'      => 'max:14',
                    'hyouji_flg05'      => 'required',
                    'nifuda_hin_nm_hidden_flg'      => 'required',
                    'hyouji_flg06'      => 'required',
                    'nifuda_sikityo_hidden_flg'      => 'required',
                    'hyouji_flg07'      => 'required',
                    'not_uriage_flg'      => 'required',
                    'hyouji_flg08'      => 'required',
                    'hyouji_flg09'      => 'required',
                    'hyouji_flg10'      => 'required',
                    'tok_g1'      => 'max:7',
                    'tok_g2'      => 'max:7',
                    'tok_g3'      => 'max:7',
                ];
                if ($formInputs['mode'] == 'edit') {
                    $rules['tok_cd'] = $rulerequiredMax;
                }
                return $rules;
            case 'delete':
                return [
                    'tok_cd'         => $rulerequiredMax
                ];
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return trans('attributes.m_tokuisaki');
    }

    public function messages(): array
    {
        return [
            'tok_cd.regex' => __('messages.MSG_ERR_008'),
            'regex' => __('messages.MSG_ERR_010'),
            'numeric' => __('messages.MSG_ERR_009'),
        ];
    }
}
