<?php

error_reporting(E_ALL);
require 'vendor/autoload.php';

use App\ApiTotalVoice;

$api = new ApiTotalVoice('76b2bd1f409cdc2e0fb46c2803f00feb');
$api->sendSms('48996190961','SMS enviado via Socket');