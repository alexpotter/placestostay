<?php

namespace app\Controllers;

class PlacesToStay extends Controller
{
    public function index()
    {
        return $this->view('index.php', [
            'message' => 'Start your search now',
        ]);
    }
}