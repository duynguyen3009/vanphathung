<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Decimal;

class PG402Request extends FormRequest
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
        
        $ruleRequireMax = 'bail|required|max:5|regex:/^[a-zA-Z0-9]+$/u';

        switch ($formInputs['action']) {
            case 'save':
                $rules = [
                    'haigo_key'         => $ruleRequireMax . '|unique:m_haigo_key,haigo_key',
                    'haigo_key_nm'      => 'bail|max:50',
                    'flat_base_keisu'   => ['bail', 'nullable', 'numeric', 'min:0' , new Decimal(2,4)],
                ];
                if ($formInputs['mode'] == 'edit') {
                    $rules['haigo_key'] = $ruleRequireMax;
                }
                return $rules;
            case 'delete':
                return [
                    'haigo_key'         => $ruleRequireMax
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
        return [
            'haigo_key'         => trans('attributes.m_haigo_key.haigo_key'),
            'haigo_key_nm'      => trans('attributes.m_haigo_key.haigo_key_nm'),
            'seihin_kbn'        => trans('attributes.m_haigo_key.seihin_kbn'),
            'flat_base_keisu'   => trans('attributes.m_haigo_key.flat_base_keisu'),
        ];
    }
    
    public function messages(): array
    {
        return [
            'haigo_key.required'        => __('messages.MSG_ERR_001'),
            'haigo_key.regex'           => __('messages.MSG_ERR_009'),
            'haigo_key.max'             => __('messages.MSG_ERR_005', ['length' => 5]),
            'haigo_key.unique'          => __('messages.MSG_ERR_014'),
            'haigo_key_nm.max'          => __('messages.MSG_ERR_005', ['length' => 50]),
            'flat_base_keisu.numeric'   => __('messages.MSG_ERR_007', ['int' => 2, 'dec' => 4]),
            'flat_base_keisu.regex'     => __('messages.MSG_ERR_007', ['int' => 2, 'dec' => 4]),
        ];
    }
}