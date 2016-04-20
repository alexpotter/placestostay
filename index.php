<?php

session_start();

include('app/Config.php');
include('app/http/Request.php');
include('app/Controllers/Controller.php');
include('app/Controllers/Api.php');
include('app/Controllers/PlacesToStay.php');
include('app/Controllers/Admin.php');

use app\Config;
use app\http\Request;

$app = new Config();
$request = new Request($app);

$request->makeResponse();