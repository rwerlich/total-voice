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
        echo "Sending HTTP headers\n";
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
        echo "Sending HTTP body\n";
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
        echo "\nResponse:\n";
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