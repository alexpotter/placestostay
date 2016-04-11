<?php

namespace app\Controllers;

class Admin extends Controller
{
    public function __construct()
    {
        if (! isset($_SESSION['admin']))
        {
            header('Location: '.$this->login());
        }
    }

    public function login()
    {
        return 'admin/login';
    }

    public function dashboard()
    {

    }
}