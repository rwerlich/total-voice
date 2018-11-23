<?php

namespace App;

use PHPUnit\Framework\TestCase;

class SocketsTest extends TestCase
{

    /*
     * Verifica se a conexão de socket funciona passando valores válidos
     */
    public function testConexaoSocket(){
        $this->assertNotFalse(Sockets::connect('werlich.blog.br', '80'));
    }

    /*
     * Testa uma requisição GET sem paprametros
     */
    public function testSendRequisitionGet(){
        $socket = Sockets::connect('werlich.blog.br', '80');
        $header = "GET / HTTP/1.1\r\n";
        $header .= "Host: www.werlich.com.br\r\n";
        $header .= "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36\r\n";
        $this->assertNotFalse(Sockets::sendRequisition($header, [], $socket));
    }

    /*
     * Testa uma requisição POST enviando um array de parametros
     */
    public function testSendRequisitionPost(){
        $socket = Sockets::connect('werlich.blog.br', '80');
        $header = "POST / HTTP/1.1\r\n";
        $header .= "Host: www.werlich.com.br\r\n";
        $header .= "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36\r\n";
        $this->assertNotFalse(Sockets::sendRequisition($header, ['message' => 'teste'], $socket));
    }


}