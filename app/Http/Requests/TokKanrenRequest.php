<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class TokKanrenRequest extends FormRequest
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
            'user_tok_cd' => 'bail|required | user_tok_cd_exist | user_tok_cd_tok_cd_exist',
            'sousai_flg' => 'required',
        ];
    }

    public function attributes(): array
    {
        return trans('attributes.m_tok_kanren');
    }

    public function messages(): array
    {
        return [
            'user_tok_cd.user_tok_cd_exist' => __('messages.MSG_ERR_022', ['target' => request()->get('user_tok_cd') . ' : ' . request()->get('user_tok_cd2')]),
            'user_tok_cd.user_tok_cd_tok_cd_exist' => __('messages.MSG_ERR_014', ['attribute' => '得意先ユーザー関連'])
        ];
    }

    public function withValidator($validator)
    {
        $validator->addExtension('user_tok_cd_exist', function ($attribute, $value, $parameters, $validator) {
            $tokuisaki = DB::table('m_tok_kanren')
                ->where('tok_cd', request()->get('user_tok_cd'))
                ->where('tok_cd2', request()->get('user_tok_cd2'))
                ->where('del_flg', false)
                ->exists();
            if ($tokuisaki) {
                return false;
            }
            return true;
        });

        $validator->addExtension('user_tok_cd_tok_cd_exist', function ($attribute, $value, $parameters, $validator) {
            $items = json_decode(request()->get('gridSearchItems'));
            $tokKanren = DB::table('m_tok_kanren')
                ->where('tok_cd', request()->get('tok_cd'))
                ->where('tok_cd2', request()->get('tok_cd2'))
                ->where('user_tok_cd', request()->get('user_tok_cd'))
                ->where('user_tok_cd2',  request()->get('user_tok_cd2'))
                ->where('del_flg', false)
                ->exists();
            if ($tokKanren) {
                return false;
            }
            foreach ($items as $item) {
                if (
                    $item->tok_cd == request()->get('tok_cd') &&
                    $item->tok_cd2 == request()->get('tok_cd2') &&
                    $item->user_tok_cd == request()->get('user_tok_cd')  &&
                    $item->user_tok_cd2 == request()->get('user_tok_cd2')
                ) return false;
            }
            return true;
        });
    }
}
