<?php

include('app/Config.php');
include('app/http/Request.php');
include('app/Controllers/Api.php');
include('app/Controllers/PlacesToStay.php');

use app\Config;
use app\http\Request;

$app = new Config();
$request = new Request();

$request->makeResponse();