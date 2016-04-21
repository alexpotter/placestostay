<?php

namespace app;

use Exception;

class User extends BaseModel
{
    protected $table = 'users';

    /**
     * @param $email
     * @return array
     * @throws Exception
     */
    public function getUserByEmail($email)
    {
        try
        {
            return $this->getFirst(['email'], [$email]);
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    public function authenticate($email, $password)
    {
        try
        {
            $user = $this->getFirst(['email'], [$email]);
            if(password_verify($password, $user['password']))
            {
                return $user;
            }
            else
            {
                return false;
            }
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    public function create($firstName, $lastName, $email, $password, $userType)
    {
        $options = [
            'cost' => 12,
        ];

        $this->insert([
            'first_name',
            'last_name',
            'email',
            'password',
            'user_type'
        ], [
            $firstName,
            $lastName,
            $email,
            password_hash($password, PASSWORD_BCRYPT, $options),
            $userType
        ]);
    }
}