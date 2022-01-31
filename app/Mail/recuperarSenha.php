<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class recuperarSenha extends Mailable
{
    use Queueable, SerializesModels;

    public $nome_usuario;
    public $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usuario, $toke)
    {
        $this->nome_usuario = $usuario;
        $this->token = $toke;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Token')->view('recuperar_senha.email');
    }
}
