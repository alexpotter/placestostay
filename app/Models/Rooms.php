<?php

namespace app\Models;

use DateTime;
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
     * ONLY return booked dates between dates given otherwise array too large
     *
     * @param $locationId
     * @param $to
     * @param $from
     * @return array
     * @throws Exception
     */
    public function getWithBookedDates($locationId, $from, $to)
    {
        $rooms = $this->get([
            'location_id' => $locationId
        ]);

        foreach ($rooms as $room)
        {
            $room->bookedDates = [];

            $bookingsModel = new Bookings();
            $bookings = $bookingsModel->getForRoom($room->ID);

            foreach($bookings as $booking)
            {
                $bookFrom = new DateTime($from);
                $bookTo = new DateTime($to);

                $bookedFrom = new DateTime($booking->date_from);
                $bookedTo = new DateTime($booking->date_to);

                if (($bookFrom >= $bookedFrom && $bookFrom <= $bookedTo) || ($bookTo >= $bookedFrom && $bookTo <= $bookedTo))
                {
                    $room->bookedDates[] = [
                        'start' => $booking->date_from,
                        'end' => $booking->date_to,
                    ];
                }
            }
        }
        
        return $rooms;
    }
}
