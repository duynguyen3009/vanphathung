<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class ShiireRequest extends FormRequest
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
        return [
            'shiire_cd' => 'required|regex:/^[a-zA-Z0-9]+$/|max:7|shiire_cd_exist',
            'tel_no' => 'required|regex:/^[0-9\-]+$/|size:15',
            'fax_no' => 'regex:/^[0-9\-]+$/|size:15|check_require_hatchu_fax_send_flg',
            'jyu_fax_no' => 'required|regex:/^[0-9\-]+$/|max:15',
            'jyu_mail_adr' => 'email|max:50',
            'cellmail_adr' => 'email|max:50',
            'sime_tm' => 'required|date_format:H:i:s',
            'hatchu_mail_adr' => 'email|max:50',
            'yubin_no' => 'required|regex:/^[0-9]+$/|size:7',
            'shiire_nm' => 'required',
            'shiire_ryaku_nm' => 'required',
            'shiire_kana_ryaku_nm' => 'required',
            'adr_ken' => 'required',
            'adr_si' => 'required',
            'adr_tyo' => 'required',
        ];
    }
    public function attributes(): array
    {
        return [
            'shiire_cd' => trans('attributes.m_shiire.shiire_cd'),
            'tel_no' => trans('attributes.m_shiire.tel_no'),
            'fax_no' => trans('attributes.m_shiire.fax_no'),
            'jyu_fax_no' => trans('attributes.m_shiire.jyu_fax_no'),
            'jyu_mail_adr' => trans('attributes.m_shiire.jyu_mail_adr'),
            'cellmail_adr' => trans('attributes.m_shiire.cellmail_adr'),
            'sime_tm' => trans('attributes.m_shiire.sime_tm'),
            'hatchu_mail_adr' => trans('attributes.m_shiire.hatchu_mail_adr'),
            'yubin_no' => trans('attributes.m_shiire.yubin_no'),
            'shiire_nm' => trans('attributes.m_shiire.shiire_nm'),
            'shiire_ryaku_nm' => trans('attributes.m_shiire.shiire_ryaku_nm'),
            'shiire_kana_ryaku_nm' => trans('attributes.m_shiire.shiire_kana_ryaku_nm'),
            'adr_ken' => trans('attributes.m_shiire.adr_ken'),
            'adr_si' => trans('attributes.m_shiire.adr_si'),
            'adr_tyo' => trans('attributes.m_shiire.adr_tyo'),
        ];
    }

    public function messages() : array
    {
        return [
            'shiire_cd.shiire_cd_exist' => trans('messages.MSG_ERR_014'),
            'yubin_no.size' => trans('messages.MSG_ERR_005'),
            'jyu_mail_adr.email' => trans('messages.MSG_ERR_011'),
            'cellmail_adr.email' => trans('messages.MSG_ERR_011'),
            'hatchu_mail_adr.email' => trans('messages.MSG_ERR_011'),
            'sime_tm.date_format' => trans('messages.MSG_ERR_012'),
        ];
    }

    public function withValidator($validator) {
        $validator->addExtension('shiire_cd_exist', function ($attribute, $value, $parameters, $validator) {
            if ($this->input('mode') === 'create') {
                $shiire_cd_exist = DB::table('m_shiire')->where('shiire_cd', $value)->exists();
                return !$shiire_cd_exist;
            }
            return true; 
        });

        $validator->addExtension('check_require_hatchu_fax_send_flg', function ($attribute, $value, $parameters, $validator) {
            return (!$this->input('hatchu_fax_send_flg') || !empty($value));
        });
    }
    
}
