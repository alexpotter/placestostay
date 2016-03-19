<?php

namespace app\Controllers;

class PlacesToStay
{
    public function __construct()
    {

    }

    function get_content($file, $data)
    {
        $template = file_get_contents($file);

        foreach($data as $key => $value)
        {
            $template = str_replace('{{{ $'.$key.' }}}', $value, $template);
        }

        return $template;
    }

    public function index()
    {
        echo $this->get_content('./Resources/Templates/index.php', [
            'response' => 'API RESPONSE'
        ]);
    }
}