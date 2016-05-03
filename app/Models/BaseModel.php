<?php

namespace app\Models;

use app\Config;
use Exception;

class BaseModel
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $app = new Config();
        $this->db = $app->db();
    }

    public function getAll()
    {
        try {
            $query = $this->db->prepare("SELECT * FROM $this->table");

            $query->setFetchMode(5);

            $query->execute();

            $rows = $query->fetchAll();

            return $rows;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    /**
     * @param array $binds
     * @return array
     * @throws Exception
     */
    public function get(array $binds)
    {
        $columns = [];
        $params = [];

        foreach ($binds as $key => $param)
        {
            $columns[] = $key;
            $params[] = $param;
        }

        $columnsForSql = '`';
        $columnsForSql = $columnsForSql . implode('` = ? AND `', $columns);
        $columnsForSql = $columnsForSql . '` = ?';

        try {
            $query = $this->db->prepare("SELECT * FROM `$this->table` WHERE ($columnsForSql)");

            $query->setFetchMode(5);

            $query->execute($params);

            $rows = $query->fetchAll();

            return $rows;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }
    
    public function getWhereLike(array $binds) 
    {
        $columns = [];
        $params = [];

        foreach ($binds as $key => $param)
        {
            $columns[] = $key;
            $params[] = '%'.$param.'%';
        }

        $columnsForSql = '`';
        $columnsForSql = $columnsForSql . implode('` LIKE ? AND `', $columns);
        $columnsForSql = $columnsForSql . '` LIKE ?';

        try {
            $query = $this->db->prepare("SELECT * FROM `$this->table` WHERE ($columnsForSql)");

            $query->setFetchMode(5);

            $query->execute($params);

            $rows = $query->fetchAll();

            return $rows;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    /**
     * @param array $binds
     * @return array
     * @throws Exception
     */
    public function getFirst(array $binds)
    {
        $columns = [];
        $params = [];

        foreach ($binds as $key => $param)
        {
            $columns[] = $key;
            $params[] = $param;
        }

        $columnsForSql = '`';
        $columnsForSql = $columnsForSql . implode('` = ? AND `', $columns);
        $columnsForSql = $columnsForSql . '` = ?';

        try {
            $query = $this->db->prepare("SELECT * FROM `$this->table` WHERE ($columnsForSql)");

            $query->setFetchMode(5);

            $query->execute($params);

            $row = $query->fetch();

            return $row;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    /**
     * @param array $binds
     * @return bool
     * @throws Exception
     */
    public function insert(array $binds)
    {
        $columns = [];
        $params = [];

        foreach ($binds as $key => $param)
        {
            $columns[] = $key;
            $params[] = $param;
        }

        try {
            $columnsForSql = '`';
            $columnsForSql = $columnsForSql . implode('`, `', $columns);
            $columnsForSql = $columnsForSql . '`';

            $bindsForSql = '?';

            if (count($params) >= 1) {
                for ($count = 1; $count < sizeof($columns); $count++) {
                    $bindsForSql = $bindsForSql . ', ?';
                }
            }

            $query = $this->db->prepare("INSERT INTO `$this->table` ($columnsForSql) VALUES ($bindsForSql);");

            $query->execute($params);
        }
        catch (Exception $e)
        {
            throw $e;
        }

        return true;
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}