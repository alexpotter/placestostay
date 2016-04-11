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
    protected $endPointFound = false;
    protected $isAdmin = false;

    public function __construct($app)
    {
        $this->app =  $app;

        if (isset($_SERVER["PATH_INFO"]))
        {
            $params = explode('/', $_SERVER["PATH_INFO"]);
            if ($params[1] == 'api')
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
                    $this->params = $params[$count];
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

        $this->api = new Api();
        $this->placesToStay = new PlacesToStay();
    }

    public function makeResponse()
    {
        if ($this->isApi)
        {
            switch ($this->route) {
                case 'search':
                    $this->api->search($this->variables[0]);
                    $this->endPointFound = true;
                    break;
                case 'book':
                    // Make functional inputs $_POST
                    // i.e. $this->api->book($_POST['from']);
                    $this->api->book($this->variables[0], $this->variables[1], $this->variables[2], $this->variables[3]);
                    $this->endPointFound = true;
                    break;
            }
        }
        else if ($this->isAdmin)
        {
            switch($this->route) {
                case 'login':
                    $this->endPointFound = true;
                    echo 'You are not logged in.';
                    break;
                case 'index':
                    $admin = new Admin();
                    $admin->dashboard();
                    $this->endPointFound = true;
                    break;
            }
        }
        else
        {
            switch ($this->route) {
                case 'index':
                    $this->placesToStay->index();
                    $this->endPointFound = true;
                    break;
                case '':
                    $this->placesToStay->index();
                    $this->endPointFound = true;
                    break;
            }
        }
        // Do 404
        if (! $this->endPointFound) echo 'Error 404';
    }
}