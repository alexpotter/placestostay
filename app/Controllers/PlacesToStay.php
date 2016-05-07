<?php

namespace app\Controllers;

use app\Models\Api as ApiModel;

class PlacesToStay extends Controller
{
    /**
     *
     */
    public function index()
    {
        $apiKeys = new ApiModel();
        $apiKey = $apiKeys->getFirst([
            'user_id' => 1,
        ]);

        return $this->view('index', [
            'visitColoradoLink' => 'http://visitcolorado.alexpotter.dev',
            'apiKey' => $apiKey->api_key,
        ]);
    }

    public function login()
    {

    }
}