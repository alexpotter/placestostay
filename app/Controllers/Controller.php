<?php

namespace app\Controllers;

class Controller
{
    public function __construct()
    {

    }

    function view($file, $data)
    {
        $template = file_get_contents($file);

        foreach($data as $key => $value)
        {
            $template = str_replace('{{{ $'.$key.' }}}', $value, $template);
        }

        return $template;
    }

    public function returnJson($array, $statusCode)
    {
        http_response_code($statusCode);
        echo json_encode($array);
    }
}