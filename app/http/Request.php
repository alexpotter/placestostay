<?php

namespace app\http;

use app\Controllers\Admin;
use app\Controllers\Api;
use app\Controllers\PlacesToStay;

class Request
{
    protected $route;
    protected $variables = [];
    protected $api;
    protected $placesToStay;
    protected $isApi = false;
    protected $app;
    protected $isAdmin = false;
    protected $admin;

    public function __construct($app)
    {
        $this->app =  $app;

        if (isset($_SERVER["PATH_INFO"]))
        {
            $endPoint = rtrim($_SERVER["PATH_INFO"],"/");
            $params = explode('/', $endPoint);

            if (! isset($params[1]))
            {
                $this->route = 'index';
            }
            else if ($params[1] == 'api')
            {
                $this->route = $params[2];
                for ($count = 3; $count < count($params); $count ++)
                {
                    $this->variables[] = $params[$count];
                }
                $this->isApi = true;
            }
            else if ($params[1] == 'admin')
            {
                $this->route = isset($params[2]) ? $params[2] : 'index';
                for ($count = 2; $count < count($params); $count ++)
                {
                    $this->variables[] = $params[$count];
                }
                $this->isAdmin = true;
            }
            else
            {
                $this->route = $params[1];
                if(isset($params[2])) $this->variables[] = $params[1];
            }
        }
        else
        {
            $this->route = 'index';
        }
    }

    public function makeResponse()
    {
        // if ((isset($_SERVER['PATH_INFO']) && file_exists('./'.$_SERVER['PATH_INFO'])) && $_SERVER['REQUEST_URI'] != '/~apotter/index.php' && $_SERVER['REQUEST_URI'] != '/~apotter/index.php/') return;
        if ((isset($_SERVER['PATH_INFO']) && file_exists('./'.$_SERVER['PATH_INFO'])) && $_SERVER['REQUEST_URI'] != '/apotter/index.php' && $_SERVER['REQUEST_URI'] != '/apotter/index.php/') return;
        if ($this->isApi)
        {
            $this->api = new Api();
            // Check API key here
            // return error if bad key
            
            switch ($this->route) {
                case 'search':
                    return $this->api->search($this->variables[0]);
                case 'book':
                    // Make functional inputs $_POST
                    // i.e. $this->api->book($_POST['from']);
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') return $this->api->returnFail('Attempted booking using GET', 405);
                    return $this->api->book($this->variables[0], $this->variables[1], $this->variables[2], $this->variables[3]);
                case 'get-booking':
                    // Use GET requires API KEY
                    echo 'View '.$this->variables[0];
                    return;
                case 'cancel-booking':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') return $this->api->returnFail('Attempted to cancel booking using GET', 405);
                    echo 'Cancel: '.$this->variables[0];
                    return;
            }
        }
        else if ($this->isAdmin)
        {
            switch($this->route) {
                case 'login':
                    $this->admin = new Admin();
                    return ($_SERVER['REQUEST_METHOD'] == 'GET') ? $this->admin->login() : $this->admin->postLogin($_POST['username'], $_POST['password']);
                case 'index':
                    $this->admin = new Admin();
                    return $this->admin->dashboard();
                case 'add-location':
                    $this->admin = new Admin();
                    return ($_SERVER['REQUEST_METHOD'] == 'GET') ? $this->admin->addLocationForm() : $this->admin->addLocation();
                case 'add-room':
                    $this->admin = new Admin();
                    return ($_SERVER['REQUEST_METHOD'] == 'GET') ? $this->admin->addRoomForm() : $this->admin->addRoom();
            }
        }
        else
        {
            $this->placesToStay = new PlacesToStay();
            switch ($this->route) {
                case 'index':
                    return $this->placesToStay->index();
                case 'login':
                    return $this->placesToStay->login();
            }
        }
        echo '404';
    }
}