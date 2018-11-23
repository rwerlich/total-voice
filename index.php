<?php

error_reporting(E_ALL);
require 'vendor/autoload.php';

use App\ApiTotalVoice;

$api = new ApiTotalVoice('xxxxxxxx'); //insira aqui seu token
$api->sendSms('48999999999','SMS enviado via Socket');