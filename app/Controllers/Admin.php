<?php

namespace app\Controllers;

class Admin extends Controller
{
    public function __construct()
    {
        if ($_SERVER['PATH_INFO'] == '/admin/login' || $_SERVER['PATH_INFO'] == '/admin/login/') return;
        if (! isset($_SESSION['admin']))
        {
            return $this->redirect($this->loginUrl());
        }
    }

    /**
     * @return string
     */
    public function loginUrl()
    {
        return 'admin/login';
    }

    /**
     *
     */
    public function login()
    {
        return $this->view('admin/index');
    }

    public function dashboard()
    {

    }

    public function addLocationForm()
    {

    }

    public function addRoomForm()
    {

    }

    public function addLocation()
    {

    }

    public function addRoom()
    {

    }
}