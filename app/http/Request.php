<?php

namespace app\http;

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

    public function __construct($app)
    {
        $this->app =  $app;

        if (isset($_GET['q']))
        {
            $params = explode('/', $_GET['q']);
            if ($params[0] == 'api')
            {
                $this->route = $params[1];
                for ($count = 2; $count < count($params); $count ++)
                {
                    $this->variables[] = $params[$count];
                }
                $this->isApi = true;
            }
            else
            {
                $this->route = $params[0];
                $this->variables[] = $params[1];
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
                    $this->api->book($this->variables[0], $this->variables[1], $this->variables[2], $this->variables[3]);
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
                case 'get':
                    echo 'foo';
                    $this->endPointFound = true;
                    break;
            }
        }
        // Do 404
        if (! $this->endPointFound) echo 'Lost yo';
    }
}