<?php

namespace app;


use PDOException;

class BaseModel
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $app = new Config();
        $this->db = $app->db();
    }

    /**
     * @param array $columns
     * @param array $params
     * @return array
     */
    public function get(array $columns, array $params)
    {
        $columnsForSql = implode(' = ?, ', $columns).' = ?';

        try {
            $query = $this->db->prepare("SELECT * FROM $this->table WHERE ($columnsForSql)");

            $count = 1;

            foreach ($params as $param)
            {
                $query->bindParam($count, $param);
                $count++;
            }

            $query->execute();

            $rows = $query->fetchAll();

            return $rows;
        }
        catch (PDOException $e)
        {
            throw $e;
        }
    }

    /**
     * @param array $columns
     * @param array $params
     * @return array
     */
    public function getFirst(array $columns, array $params)
    {
        $columnsForSql = implode(' = ?, ', $columns).' = ?';

        try {
            $query = $this->db->prepare("SELECT * FROM $this->table WHERE ($columnsForSql)");

            $count = 1;

            foreach ($params as $param)
            {
                $query->bindParam($count, $param);
                $count++;
            }

            $query->execute();

            $rows = $query->fetch();

            return $rows;
        }
        catch (PDOException $e)
        {
            throw $e;
        }
    }

    public function insert(array $columns, array $params)
    {
        $columnsForSql = implode(', ', $columns);
        $bindsForSql = '?';

        if (count($params) >= 1)
        {
            for($count = 1; $count < sizeof($columns); $count ++)
            {
                $bindsForSql = $bindsForSql . ', ?';
            }
        }

        $query = $this->db->prepare("INSERT INTO $this->table ($columnsForSql) VALUES ($bindsForSql);");

        $count = 1;

        foreach($params as $param)
        {
            $query->bindParam($count, $param);
            $count++;
        }

        echo '<pre>';
        $query->debugDumpParams();
        print_r($params);
        //die;

        $query->execute();
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}