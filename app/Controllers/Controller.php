<?php

namespace app\Controllers;

class Controller
{
    public function __construct()
    {

    }

    /**
     * @param $file
     * @param $data
     */
    function view($file, $data = null)
    {
        if ($data) extract($data);
        $url = 'http://'.$_SERVER['SERVER_NAME'].'/';
        include ('./Resources/Templates/'.$file.'.php');
    }

    /**
     * @param $location
     */
    public function redirect($location)
    {
        header('Location: '.$location);
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