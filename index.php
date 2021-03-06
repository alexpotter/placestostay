<?php

session_start();

include('app/Config.php');
include('app/http/Request.php');
include('app/Controllers/Controller.php');
include('app/Controllers/Api.php');
include('app/Controllers/PlacesToStay.php');
include('app/Controllers/Admin.php');
include('app/Models/BaseModel.php');
include('app/Models/Users.php');
include('app/Models/Locations.php');
include('app/Models/Rooms.php');
include('app/Models/Bookings.php');
include('app/Models/Api.php');

use app\Config;
use app\http\Request;

$app = new Config();
$app->boot();
$request = new Request($app);

$request->makeResponse();