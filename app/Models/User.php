<?php

namespace app;

use Exception;

class User extends BaseModel
{
    protected $table = 'users';

    /**
     * @param $name
     * @return array
     * @throws Exception
     */
    public function getUserByUsername($name)
    {
        try
        {
            return $this->getFirst(['firstName'], [$name]);
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    public function authenticate()
    {

    }
}