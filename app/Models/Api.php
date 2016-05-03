<?php

namespace app\Models;

use Exception;

class Api extends BaseModel
{
    protected $table = 'api';

    /**
     * @param $userId
     * @return bool
     */
    public function add($userId)
    {
        $key = md5(microtime().rand());

        return $this->insert([
            'api_key' => $key,
            'user_id' => $userId,
        ]);
    }

    /**
     * @param $key
     * @return array
     * @throws Exception
     */
    public function authenticateKey($key)
    {
        try {
            return $this->get([
                'api_key' => $key,
            ]);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}