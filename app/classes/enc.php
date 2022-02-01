<?php

namespace app\classes;

class enc
{

    //-----usar para encriptar-----
    public function encriptar($valor)
    {
        return bin2hex(openssl_encrypt($valor, 'aes-256-cbc', '4Hzxso5WHSxMYA93flJ14R6qtd0HftKF', OPENSSL_RAW_DATA, 'p4Sml4pAdinhB384'));
    }
    //-----usar para densencriptar--
    public function desencriptar($valor_enc)
    {
        return openssl_decrypt(hex2bin($valor_enc), 'aes-256-cbc', '4Hzxso5WHSxMYA93flJ14R6qtd0HftKF', OPENSSL_RAW_DATA, 'p4Sml4pAdinhB384');
    }
}
