<?php

require 'Sockets.php';

class ApiTotalVoice
{

    private $acessToken;

    public function __construct(String $token)
    {
        $this->acessToken = $token;
    }

    public function sendSms(String $phoneNumber, String $msg)
    {
        // retrieve port number of service http
        $port = getservbyname('http', 'tcp');
        // retrieve ip address of host
        $ip = gethostbyname('api.totalvoice.com.br');
        $socket = Sockets::connect($ip, $port);
        if(!$socket){
            return;
        }
        $header = "POST /sms HTTP/1.1\r\n";
        $header .= "Host: api.totalvoice.com.br\r\n";
        $header .= "Accept:  application/json\r\n";
        $header .= "Content-Type:  application/json\r\n";
        $header .= "Access-Token:  {$this->acessToken}\r\n";
        $header .= "Connection: Keep-Alive\r\n\r\n";
        $data = array(
            'numero_destino' => '48996190961',
            'mensagem' => 'Teste de sms enviado via socket'
        );
        if(Sockets::sendRequisition($header, $data, $socket)){
            Sockets::read($socket);
            Sockets::close($socket);
        }
    }

}