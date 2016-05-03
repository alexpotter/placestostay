<?php

namespace app\Models;

use Exception;

class Room extends BaseModel
{
    protected $table = 'rooms';

    /**
     * @param $locationId
     * @param $numberOfBeds
     * @param $description
     * @param $price
     * @param $available_from
     * @param $available_to
     * @throws Exception
     */
    public function add($locationId, $numberOfBeds, $description, $price, $available_from, $available_to)
    {
        try {
            $this->insert([
                'room_description' => $description,
                'location_id' => $locationId,
                'number_of_beds' => $numberOfBeds,
                'room_price' => $price,
                'available_from' => $available_from,
                'available_to' => $available_to,
            ]);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

