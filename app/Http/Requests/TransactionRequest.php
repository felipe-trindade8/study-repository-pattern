<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'exists:users,id'
            ],
            'name' => [
                'required',
                'min:3',
                'max:150'
            ],
            'payment_method_id' => [
                'required',
                'exists:payment_methods,id'
            ]
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'O campo "user_id" é obrigatório',
            'user_id.exists' => 'O "user_id" não foi encontrado',
            'name.required' => 'O campo "name" é obrigatório',
            'name.min' => 'O campo "name" deve ter no mínimo 3 caracteres',
            'name.max' => 'O campo "name" deve ter no máximo 150 caracteres',
            'credit_card_id.required' => 'O campo "credit_card_id" é obrigatório',
            'credit_card_id.exists' => 'O "credit_card_id" não foi encontrado',
        ];
    }
}
