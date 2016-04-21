<?php

namespace app\Controllers;

use app\User;

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

    /**
     * @param $email
     * @param $password
     */
    public function postLogin($email, $password)
    {
        $user = new User();
        $admin = $user->authenticate($email, $password);
        $admin ? $_SESSION['admin'] = $admin : $this->flash('error', 'Incorrect username password');
        return $this->redirect('admin');
    }

    public function logout()
    {
        session_destroy();
        return $this->redirect('admin');
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