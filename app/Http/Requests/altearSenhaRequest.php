<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class altearSenhaRequest extends FormRequest
{
 
    public function rules()
    {
        return [
            
 
                'nova_senha' => ['required','min:8'],
                'confirma_senha' => ['required','min:8'],
                'atual_senha' => ['required']
                
        ];
    }

    public function messages(){

        return  [

            'nova_senha.required' => 'Informee a nova senha.',
            'nova_senha.min' => 'Nova senha deve ter no munimo 8 caracter.',
            'confirma_senha.required' => 'Confirme a nova senha',
            'confirma_senha.min' => 'Confirmar nova senha deve ter no munimo 8 caracter.',
            'atual_senha.required' => 'Informee a senha',
            
            
        ];

    }
}
