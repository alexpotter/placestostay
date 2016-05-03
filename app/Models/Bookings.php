<?php

namespace app\Models;

class Bookings extends BaseModel
{
    protected $table = 'bookings';

    /**
     * @param $roomId
     * @return array
     * @throws \Exception
     */
    public function getForRoom($roomId)
    {
        return $this->get([
            'room_id' => $roomId, 
        ]);
    }
}