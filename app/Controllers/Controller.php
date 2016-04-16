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
        include ('./Resources/Templates/'.$file.'.php');
    }

    /**
     * @param null $path
     * @return string
     */
    public function url($path = null)
    {
        return 'http://'.$_SERVER['SERVER_NAME'].'/'.$path;
    }

    /**
     * @param $location
     */
    public function redirect($location)
    {
        header('Location: http://'.$_SERVER['SERVER_NAME'].'/index.php/'.$location);
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