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

        if ($flash = $this->checkFlash()) extract($flash);
        $this->removeFlash();

        include ('./Resources/Templates/'.$file.'.php');
    }

    /**
     * @param null $path
     * @return string
     */
    public function url($path = null)
    {
        // return 'http://'.$_SERVER['SERVER_NAME'].'/~apotter/'.$path;
        return 'http://'.$_SERVER['SERVER_NAME'].'/apotter/'.$path;
    }

    /**
     * @param $location
     */
    public function redirect($location)
    {
        // header('Location: http://'.$_SERVER['SERVER_NAME'].'/~apotter/index.php/'.$location);
        header('Location: http://'.$_SERVER['SERVER_NAME'].'/apotter/index.php/'.$location);
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

    /**
     * @param $param
     * @param $message
     */
    public function flash($param, $message)
    {
        $_SESSION['flash'] = [
            $param => $message
        ];
    }

    /**
     * @return bool
     */
    public function checkFlash()
    {
        return (isset($_SESSION['flash'])) ? $_SESSION['flash'] : false;
    }

    /**
     *
     */
    public function removeFlash()
    {
        unset($_SESSION['flash']);
    }
}