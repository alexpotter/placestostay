<?php

namespace app\Controllers;

use app\Models\Location;
use app\Models\User;
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

    /**
     * @param $name
     * @param $streetNumber
     * @param $addressLine1
     * @param $town
     * @param $postcode
     * @param $country
     * @param $googleId
     * @param $lat
     * @param $lng
     * @param $location_type
     */
    public function addLocation($name, $streetNumber, $addressLine1, $town, $postcode, $country, $googleId, $lat, $lng, $location_type)
    {
        if (!$location_type)
        {
            return $this->returnJson([
                'message' => 'Location type is required'
            ], 400);
        }

        try {
            $location = new Location();
            $location->add($name, $streetNumber, $addressLine1, $town, $postcode, $country, $googleId, $lat, $lng, $location_type);
        }
        catch (Exception $e) {
            return $this->returnJson([
                'error' => $e->getMessage(),
                'message' => 'Duplicate location entered.'
            ], 400);
        }

        return $this->returnJson([
            'message' => 'Sucessfully added new location.'
        ], 200);
    }

    public function getLocations()
    {
        $location = new Location();
        try {
            return $this->returnJson([
                'locations' => $location->all()
            ], 200);
        }
        catch (Exception $e) {
            return $this->returnJson([
                'error' => $e->getMessage(),
                'message' => 'Duplicate location entered.'
            ], 400);
        }
    }

    public function addRoom()
    {

    }
}