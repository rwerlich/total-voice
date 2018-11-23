<?php

namespace App;
use App\Sockets;

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
        if (!$socket) {
            return;
        }
        $header = "POST /sms HTTP/1.1\r\n";
        $header .= "Host: api.totalvoice.com.br\r\n";
        $header .= "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36\r\n";
        $header .= "Access-Token:  {$this->acessToken}\r\n";
        $data = [
            'numero_destino' => $phoneNumber,
            'mensagem' => $msg
        ];
        if (Sockets::sendRequisition($header, $data, $socket)) {
            Sockets::close($socket);
        }
    }
}