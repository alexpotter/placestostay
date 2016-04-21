<?php

namespace app;

use PDO;

class ConfigExample {
    protected $dbHost = "localhost";
    protected $dbName = "db_name";
    protected $dbUsername = "username";
    protected $dbPassword = "password";
    protected static $url;

    protected $conn;

    public function __construct()
    {
        self::$url = $_SERVER['SERVER_NAME'];
        $this->conn = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUsername, $this->dbPassword);
    }

    public function url($route = null)
    {
        return self::$url.'/'.$route;
    }

    public function db()
    {
        return $this->conn;
    }
}