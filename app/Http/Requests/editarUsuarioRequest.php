<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class editarUsuarioRequest extends FormRequest
{
 
    public function rules()
    {
        return [
            
                'text_nome' => ['required','min:5', 'max:30'],
                'text_email' => ['required','email', 'max:30'],
                'text_senha' => ['required']
                
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
            'text_senha.required' => 'informee a senha',
            
            
        ];

    }
}
