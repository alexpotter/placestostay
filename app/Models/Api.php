<?php

namespace app\Models;

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
}