<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DB;

class HaigoKeyMeiRequest extends FormRequest
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
        $rules =  [
            'haigo_key' => 'required',
            'hin_cd' => 'required',
            'kikaku_cd' => 'required',
            'bihikuru_keisu' => ['nullable', 'decimal_ex:2,4'],
            'tonyu_group_no' => ['nullable', 'integer', 'max:'.config()->get('params.DB_INT_SIGNED_MAX')],
            'disp_jun' => ['nullable', 'integer', 'max:'.config()->get('params.DB_INT_SIGNED_MAX')],
            'ganryo_kbn' => ['nullable', 'size:2'],
            'haigo_key_mei' => 'haigo_key_mei_exist'
        ];
        if ($this->method() == 'PUT') {
            unset($rules['haigo_key_mei']);
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'haigo_key' => trans('attributes.m_haigo_key_mei.haigo_key'),
            'hin_cd' => trans('attributes.m_haigo_key_mei.hin_cd'),
            'kikaku_cd' => trans('attributes.m_haigo_key_mei.kikaku_cd'),
            'bihikuru_keisu' => trans('attributes.m_haigo_key_mei.bihikuru_keisu'),
            'tonyu_group_no' => trans('attributes.m_haigo_key_mei.tonyu_group_no'),
            'disp_jun' => trans('attributes.m_haigo_key_mei.disp_jun'),
            'ganryo_kbn' => trans('attributes.m_haigo_key_mei.ganryo_kbn'),
            'haigo_key_mei' => trans('site.title.haigo_key_mei.index')
        ];
    }

    public function messages(): array
    {
        return [
            'hin_cd.required' => trans('messages.MSG_ERR_002'),
            'kikaku_cd.required' => trans('messages.MSG_ERR_002'),
            'tonyu_group_no.integer' => trans('messages.MSG_ERR_008'),
            'disp_jun.integer' => trans('messages.MSG_ERR_008'),
            'haigo_key_mei.haigo_key_mei_exist'=> trans('messages.MSG_ERR_014')
        ];
    }

    public function withValidator($validator) {
        $validator->addExtension('haigo_key_mei_exist', function ($attribute, $value, $parameters, $validator) {
            $haigoKeyMei = DB::table('m_haigo_key_mei')->where('haigo_key', request()->get('haigo_key'))->where('hin_cd', request()->get('hin_cd'))->where('kikaku_cd', request()->get('kikaku_cd'))->where('del_flg', false)->exists();
            if($haigoKeyMei) {
                return false;
            }
            return true;
        });
    }

}
