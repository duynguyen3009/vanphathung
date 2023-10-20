<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class GanryoPumpRequest extends FormRequest
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

        $rules = [
            'ktn_cd'            => 'required',
            'dispenser_kbn'     => 'required',
            'hin_cd'            => 'required',
            'kikaku_cd'         => 'required',
            'lot_no'            => 'required|max:15',
            'keisu'             => 'required|decimal_ex:1,2',
            'ganryo_pump'       => 'ganryo_pump_exist',

            'row1.1'            => 'decimal_ex:3,4',
            'row1.2'            => 'decimal_ex:3,4',
            'row1.3'            => 'decimal_ex:3,4',
            'row1.average'      => 'required|decimal_ex:3,4',

            'row2.1'            => 'decimal_ex:3,4',
            'row2.2'            => 'decimal_ex:3,4',
            'row2.3'            => 'decimal_ex:3,4',
            'row2.average'      => 'required|decimal_ex:3,4',

            'row3.1'            => 'decimal_ex:3,4',
            'row3.2'            => 'decimal_ex:3,4',
            'row3.3'            => 'decimal_ex:3,4',
            'row3.average'      => 'required|decimal_ex:3,4',

            'row4.1'            => 'decimal_ex:3,4',
            'row4.2'            => 'decimal_ex:3,4',
            'row4.3'            => 'decimal_ex:3,4',
            'row4.average'      => 'required|decimal_ex:3,4',
        ];

        switch ($formInputs['mode']) {
            case 'edit':
                unset($rules['ktn_cd']);
                unset($rules['dispenser_kbn']);
                unset($rules['hin_cd']);
                unset($rules['kikaku_cd']);
                unset($rules['ganryo_pump']);
                unset($rules['row1.average']);
                unset($rules['row2.average']);
                unset($rules['row3.average']);
                unset($rules['row4.average']);
                break;
            case 'copy':
                unset($rules['row1.average']);
                unset($rules['row2.average']);
                unset($rules['row3.average']);
                unset($rules['row4.average']);
                break;
        }

        return $rules;
    }

    public function withValidator($validator) {
        $formInputs = $this->all();

        $validator->addExtension('ganryo_pump_exist', function ($attribute, $value, $parameters, $validator) use($formInputs){
            $res = DB::table('m_ganryo_pump')
                        ->where('ktn_cd', $formInputs['ktn_cd'])
                        ->where('hin_cd', $formInputs['hin_cd'])
                        ->where('dispenser_kbn', $formInputs['dispenser_kbn'])
                        ->where('kikaku_cd', $formInputs['kikaku_cd'])
                        ->exists();

            if($res) {
                return false;
            }
            return true;
        });
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'ktn_cd'         => trans('attributes.m_ganryo_pump.ktn_cd'),
            'dispenser_kbn'  => trans('attributes.m_ganryo_pump.dispenser_kbn'),
            'hin_cd'         => trans('attributes.m_ganryo_pump.hin_cd'),
            'kikaku_cd'      => trans('attributes.m_ganryo_pump.kikaku_cd'),
            'lot_no'         => trans('attributes.m_ganryo_pump.lot_no'),
            'keisu'          => trans('attributes.m_ganryo_pump.keisu'),
            'row1.1'         => trans('attributes.m_ganryo_pump.row1_1'),
            'row1.2'         => trans('attributes.m_ganryo_pump.row1_2'),
            'row1.3'         => trans('attributes.m_ganryo_pump.row1_3'),
            'row1.average'   => trans('attributes.m_ganryo_pump.row1_average'),

            'row2.1'         => trans('attributes.m_ganryo_pump.row2_1'),
            'row2.2'         => trans('attributes.m_ganryo_pump.row2_2'),
            'row2.3'         => trans('attributes.m_ganryo_pump.row2_3'),
            'row2.average'   => trans('attributes.m_ganryo_pump.row2_average'),

            'row3.1'         => trans('attributes.m_ganryo_pump.row3_1'),
            'row3.2'         => trans('attributes.m_ganryo_pump.row3_2'),
            'row3.3'         => trans('attributes.m_ganryo_pump.row3_3'),
            'row3.average'   => trans('attributes.m_ganryo_pump.row3_average'),

            'row4.1'         => trans('attributes.m_ganryo_pump.row4_1'),
            'row4.2'         => trans('attributes.m_ganryo_pump.row4_2'),
            'row4.3'         => trans('attributes.m_ganryo_pump.row4_3'),
            'row4.average'   => trans('attributes.m_ganryo_pump.row4_average'),

            'ganryo_pump' => trans('site.title.ganryo_pump.create')
        ];
    }
    
    public function messages(): array
    {
        return [
            'ktn_cd.required'           => __('messages.MSG_ERR_002'),
            'dispenser_kbn.required'    => __('messages.MSG_ERR_002'),
            'hin_cd.required'           => __('messages.MSG_ERR_002'),
            'kikaku_cd.required'        => __('messages.MSG_ERR_002'),
            'lot_no.required'           => __('messages.MSG_ERR_001'),
            'lot_no.max'                => __('messages.MSG_ERR_005', ['length' => 15]),
            'keisu.required'            => __('messages.MSG_ERR_001'),

            'ganryo_pump.ganryo_pump_exist' =>  __('messages.MSG_ERR_014')
        ];
    }

    
}