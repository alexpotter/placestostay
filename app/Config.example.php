<?php

namespace app;

use app\Models\Api;
use app\Models\Users;
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

    /**
     *
     */
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

                $admin = new Users();
                $admin->create('Alex', 'Potter', 'alex.potter1993@gmail.com', 'Solent24', 1);
                $admin->create('Nick', 'Whitelegg', 'info@visitcollerado.com', 'Solent', 2);

                $api = new Api();
                $api->add(1);
                $api->add(2);
            }
            catch (Exception $e)
            {

            }
        }
    }

    /**
     * @param null $route
     * @return string
     */
    public function url($route = null)
    {
        return self::$url.'/'.$route;
    }

    /**
     * @return PDO
     */
    public function db()
    {
        return $this->conn;
    }
}