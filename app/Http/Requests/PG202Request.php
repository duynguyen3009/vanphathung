<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PG202Request extends FormRequest
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
        $jyuEntryFukaFlg = $this->generateKeyRow('jyu_entry_fuka_flg');
        
        $rules = [
            $jyuEntryFukaFlg => 'required',
        ];

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        $jyuEntryFukaFlg = $this->generateKeyRow('jyu_entry_fuka_flg');

        return [
            $jyuEntryFukaFlg         => '受注入力不可フラグ',
        ];
    }
    
    public function messages(): array
    {
        $jyuEntryFukaFlg = $this->generateKeyRow('jyu_entry_fuka_flg');
        $jyuEntryFukaFlg = $jyuEntryFukaFlg . '.required';
        
        return [
            $jyuEntryFukaFlg  => trans('messages.MSG_ERR_002'),
        ];
    }

    private function generateKeyRow($name)
    {
        $formInputs     = $this->all();
        

        switch ($name) {
            case 'jyu_entry_fuka_flg':
                $keyRow = $formInputs['hin_cd'] . '_' . $formInputs['kikaku_cd'] . '_' . $formInputs['ktn_cd'];
                $key    = 'jyu_entry_fuka_flg__' . $keyRow;
                return $key;
                break;
        }
    }
}