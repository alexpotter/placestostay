<?php

namespace app\Controllers;

class Admin
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