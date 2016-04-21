<?php

namespace app\Controllers;

use app\User;
use Exception;

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
     * @param $username
     * @param $password
     */
    public function postLogin($username, $password)
    {
        $user = new User();
        echo '<pre>';
        try
        {
            print_r($user->getUserByUsername($username));
        }
        catch (Exception $e)
        {
            print_r($e);
        }
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