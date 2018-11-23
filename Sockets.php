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
            echo "Fail to socket_create(), reason: " . socket_strerror(socket_last_error());
            return false;
        }
        echo "Establishing connection {$ip}:{$port}\n";
        $connect = socket_connect($socket, $ip, $port);
        if (!$connect) {
            echo "Fail to socket_connect(), reason: " . socket_strerror(socket_last_error($socket));
            return false;
        }
        return $socket;
    }

    /*
     * Send a Requisition to server
     */
    public static function sendRequisition(String $headers, array $data, $socket)
    {

        echo "Send requisiton\n";
        if (!empty($data)) {
            $json = json_encode($data);
            $length = strlen($json);
            $headers .= "Content-Type:  application/json\r\n";
            $headers .= "Content-Length: {$length} \r\n\r\n";
            $headers .= $json;
        }
        if (!socket_write($socket, $headers, strlen($headers))) {
            return false;
        }
        echo $headers;
        self::read($socket);
        return true;
    }


    /*
     * Read server response
     */
    public static function read($socket)
    {
        echo "\n\nResponse:\n";
        while ($response = socket_read($socket, 2048)) {
            echo "{$response}\n";
        }
    }

    /*
     * Close socket connection
     */
    public static function close($socket)
    {
        echo "\nClosing socket...\n";
        socket_close($socket);
        echo "Socket closed\n";
        return true;
    }
}