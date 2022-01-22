<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class loguinRequest extends FormRequest
{

    public function rules()
    {
        return [
            
                'text_email' => ['required','email'],
                'text_senha' => 'required'
        ];
    }

    public function messages(){

        return  [
            'text_email.required' => 'Informe o usuario',
            'text_email.email' => 'tem que ser um email',
            'text_senha.required' => 'informe a senha'
        ];

    }
}


