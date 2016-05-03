<?php

namespace app\Models;

use Exception;

class Rooms extends BaseModel
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

    /**
     * @return array
     * @throws Exception
     */
    public function all()
    {
        try {
            return $this->getAll();
        }
        catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param array $binds
     * @return array|mixed
     */
    public function getWithBookedDates(array $binds)
    {
        $rooms = $this->get($binds);

        foreach ($rooms as $room)
        {
            $room->bookedDates = [];

            $bookingsModel = new Bookings();
            $bookings = $bookingsModel->getForRoom($room->ID);

            foreach($bookings as $booking)
            {
                $room->bookedDates[] = [
                    'start' => $booking->date_from,
                    'end' => $booking->date_to,
                ];
            }
        }
        
        return $rooms;
    }
}

