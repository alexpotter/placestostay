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

            foreach ($params as $param) {
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

            foreach ($params as $param) {
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

    public function insert()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}