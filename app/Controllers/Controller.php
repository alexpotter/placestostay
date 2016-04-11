<?php

namespace app\Controllers;

class Controller
{
    public function __construct()
    {

    }

    function view($file, $data)
    {
        extract($data);
        include ('./Resources/Templates/'.$file);
    }

    /**
     * @param $array
     * @param $statusCode
     */
    public function returnJson($array, $statusCode)
    {
        http_response_code($statusCode);
        echo json_encode($array);
    }
}