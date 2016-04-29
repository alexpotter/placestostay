<?php

namespace app\Models;

use Exception;

class User extends BaseModel
{
    protected $table = 'users';
    protected $firstName;
    protected $lastName;
    protected $email;

    /**
     * @param $firstName
     * @param $lastName
     * @param $email
     */
    public function set($firstName, $lastName, $email)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    /**
     * @param $email
     * @return array
     * @throws Exception
     */
    public function getUserByEmail($email)
    {
        try
        {
            $user = $this->getFirst([
                'email' => $email,
            ]);
            $this->set($user['first_name'], $user['last_name'], $user['email']);
            return $this;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    /**
     * @param $email
     * @param $password
     * @return array|bool
     * @throws Exception
     */
    public function authenticate($email, $password)
    {
        try
        {
            $user = $this->getFirst([
                'email' => $email,
            ]);

            if($user['user_type'] == 1 && password_verify($password, $user['password']))
            {
                $this->set($user['first_name'], $user['last_name'], $user['email']);
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

    /**
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $password
     * @param $userType
     * @throws Exception
     */
    public function create($firstName, $lastName, $email, $password, $userType)
    {
        $options = [
            'cost' => 12,
        ];

        $this->insert([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT, $options),
            'user_type' => $userType,
        ]);
    }
}