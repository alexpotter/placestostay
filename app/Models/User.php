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

    public function create($firstName, $lastName, $email, $password, $userType)
    {
        $options = [
            'cost' => 12,
        ];

        $this->insert(['firstName', 'lastName', 'email', 'password', 'user_type'], [$firstName, $lastName, $email, password_hash($password, PASSWORD_BCRYPT, $options), $userType]);
    }
}