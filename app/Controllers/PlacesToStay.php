<?php

namespace app\Controllers;

class PlacesToStay extends Controller
{
    public function index()
    {
        echo $this->view('./Resources/Templates/index.php', [
            'message' => 'Start your search now'
        ]);
    }
}