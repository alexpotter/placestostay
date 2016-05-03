<?php

namespace app;

use app\Models\Api;
use app\Models\User;
use Exception;
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
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function boot()
    {
        try {
            $this->conn->query('SELECT * FROM users');
        }
        catch (Exception $e)
        {
            try {
                $query = file_get_contents('./install/database.sql');
                $statement = $this->conn->prepare($query);
                $statement->execute();

                $admin = new User();
                $admin->create('Alex', 'Potter', 'alex.potter1993@gmail.com', 'Solent24', 1);

                $api = new Api();
                $api->add($_SESSION['admin']['ID']);
            }
            catch (Exception $e)
            {

            }
        }
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