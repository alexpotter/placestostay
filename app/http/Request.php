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
                $this->api = new Api();
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

        $this->placesToStay = new PlacesToStay();
    }

    public function makeResponse()
    {
        if ((isset($_SERVER['PATH_INFO']) && file_exists('./'.$_SERVER['PATH_INFO'])) && $_SERVER['REQUEST_URI'] != '/index.php' && $_SERVER['REQUEST_URI'] != '/index.php/') return;
        if ($this->isApi)
        {
            switch ($this->route) {
                case 'search':
                    return $this->api->search($this->variables[0]);
                case 'book':
                    // Make functional inputs $_POST
                    // i.e. $this->api->book($_POST['from']);
                    return $this->api->book($this->variables[0], $this->variables[1], $this->variables[2], $this->variables[3]);
            }
        }
        else if ($this->isAdmin)
        {
            switch($this->route) {
                case 'login':
                    $this->admin = new Admin();
                    return $this->admin->login();
                case 'index':
                    $this->admin = new Admin();
                    return $this->admin->dashboard();
            }
        }
        else
        {
            switch ($this->route) {
                case 'index':
                    return $this->placesToStay->index();
                case '':
                    return $this->placesToStay->index();
            }
        }
        echo '404';
    }
}