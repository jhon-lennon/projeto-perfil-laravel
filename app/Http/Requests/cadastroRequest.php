<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class cadastroRequest extends FormRequest
{
 
    public function rules()
    {
        return [
            
                'text_nome' => ['required','min:5', 'max:30'],
                'text_email' => ['required','email', 'max:30'],
                'text_senha' => ['required','min:8'],
                'text_senha_confirma' => 'required'
        ];
    }

    public function messages(){

        return  [
            'text_nome.required'=> 'Informe seu nome',
            'text_nome.min'=> 'O nome deve ter entre 5 e 30 caracter',
            'text_nome.max'=> 'O nome deve ter entre 5 e 30 caracter',
            'text_email.required' => 'Informe um Email',
            'text_email.email' => 'Email invalido',
            'text_email.max' => 'O email nao pode ter mais de 30 caracter',
            'text_senha.required' => 'informe a senha',
            'text_senha.min'=> 'A senha dever ter no minimo 8 caracter',
            'text_senha_confirma.required'=> 'Confirme a senha'
        ];

    }
}
