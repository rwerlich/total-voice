<?php

class Sockets
{


    /*
     * Create a Socket conection
     */
    public static function connect(String $ip, String $port)
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$socket) {
            echo "Falha na função socket_create(), motivo: " . socket_strerror(socket_last_error());
            return false;
        }
        echo "Conectando ao ip: {$ip} na porta: {$port}...\n\n";
        $connect = socket_connect($socket, $ip, $port);
        if (!$connect) {
            echo "Falha na função socket_connect(), motivo: {$connect} " . socket_strerror(socket_last_error($socket));
            return false;
        }
        return $socket;
    }

    /*
     * Sen a Requisition to server
     */
    public static function sendRequisition(String $headers = '', array $data = [], $socket)
    {
        if (!empty($headers)) {
            if (!self::sendHeaders($headers, $socket)) {
                return false;
            }
        }
        if (!empty($data)) {
            if (!self::sendBody($data, $socket)) {
                return false;
            }
        }
        return true;
    }

    /*
     * Send requisiton headers
     */
    private static function sendHeaders(String $headers, $socket)
    {
        echo "Sending HTTP headers...\n";
        if (!socket_write($socket, $headers, strlen($headers))) {
            return false;
        }
        return true;
    }

    /*
     * Send requisiton body
     */
    private static function sendBody(array $data, $socket)
    {
        $json = json_encode($data);
        echo "Sending data...\n";
        if (!socket_send($socket, $json, strlen($json), 0)) {
            return false;
        }
        return true;
    }


    /*
     * Read server response
     */
    public static function read($socket)
    {
        echo "Response:\n\n";
        while ($response = socket_read($socket, 2048)) {
            echo "{$response}\n";
        }
    }

    /*
     * Close socket connection
     */
    public static function close($socket)
    {
        echo "Closing socket...\n";
        socket_close($socket);
        echo "Socket closed\n";
        return true;
    }

}