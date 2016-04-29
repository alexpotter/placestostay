<?php

namespace app\Controllers;

use app\Models\Location;
use app\Models\User;

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
        if(isset($_SESSION['admin']))
        {
            return $this->view('admin');
        }
        else
        {
            return $this->view('admin/index');
        }
    }

    /**
     * @param $email
     * @param $password
     */
    public function postLogin($email, $password)
    {
        $user = new User();
        $admin = $user->authenticate($email, $password);
        if($admin)
        {
            $_SESSION['admin'] = $admin;
            return $this->redirect('admin');
        }
        else
        {
            $this->flash([
                'error' => 'Incorrect username password',
                'email' => $email,
            ]);
            return $this->redirect('admin/login');
        }
    }

    public function logout()
    {
        session_destroy();
        return $this->redirect('admin');
    }

    public function dashboard()
    {
        return $this->view('admin/dashboard');
    }

    public function addLocationForm()
    {
        return $this->view('admin/location');
    }

    public function addRoomForm()
    {

    }

    public function addLocation($name, $streetNumber, $addressLine1, $town, $postcode, $country, $googleId, $lat, $lng)
    {
        $location = new Location();
        $location->add($name, $streetNumber, $addressLine1, $town, $postcode, $country, $googleId, $lat, $lng);
        echo 'Added new location';
    }

    public function addRoom()
    {

    }
}