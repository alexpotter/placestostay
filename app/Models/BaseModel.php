<?php

namespace app;

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

    /**
     * @param array $columns
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function get(array $columns, array $params)
    {
        $columnsForSql = implode(' = ? AND ', $columns).' = ?';

        try {
            $query = $this->db->prepare("SELECT * FROM $this->table WHERE ($columnsForSql)");

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
     * @param array $columns
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function getFirst(array $columns, array $params)
    {
        $columnsForSql = implode(' = ? AND ', $columns).' = ?';

        try {
            $query = $this->db->prepare("SELECT * FROM $this->table WHERE ($columnsForSql)");

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
     * @param array $columns
     * @param array $params
     * @return bool
     * @throws Exception
     */
    public function insert(array $columns, array $params)
    {
        try {
            $columnsForSql = implode(', ', $columns);
            $bindsForSql = '?';

            if (count($params) >= 1) {
                for ($count = 1; $count < sizeof($columns); $count++) {
                    $bindsForSql = $bindsForSql . ', ?';
                }
            }

            $query = $this->db->prepare("INSERT INTO $this->table ($columnsForSql) VALUES ($bindsForSql);");

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