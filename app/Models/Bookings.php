<?php

namespace app\Models;

use DateTime;
use Exception;

class Bookings extends BaseModel
{
    protected $table = 'bookings';

    /**
     * @param $roomId
     * @return array
     * @throws Exception
     */
    public function getForRoom($roomId)
    {
        return $this->get([
            'room_id' => $roomId, 
        ]);
    }

    /**
     * @param $roomId
     * @param $dateFrom
     * @param $dateTo
     * @return mixed
     * @throws Exception
     */
    public function authoriseBookingAndGetTotal($roomId, $dateFrom, $dateTo)
    {
        try {
            $dateFrom = new DateTime($dateFrom);
            $dateTo = new DateTime($dateTo);
            $now = new DateTime('now');

            if ($dateFrom <= $now || $dateTo <= $now)
            {
                throw new Exception('A booking cannot be made in the past');
            }
            if ($dateFrom >= $dateTo)
            {
                throw new Exception('A bookings start should precede the end');
            }

            $bookings = $this->get([
                'room_id' => $roomId
            ]);
            
            foreach ($bookings as $booking)
            {
                $bookedDateFrom = new DateTime($booking->date_from);
                $bookedDateTo = new DateTime($booking->date_to);

                if (($dateFrom <= $bookedDateTo) && ($bookedDateFrom <= $dateTo))
                {
                    throw new Exception('A booking already exists within this period');
                }
            }
        }
        catch (Exception $e) {
            throw $e;
        }

        return $this->getBookingTotal($roomId, $dateFrom, $dateTo);
    }

    /**
     * @param $roomId
     * @param DateTime $dateFrom
     * @param DateTime $dateTo
     * @return mixed
     * @throws Exception
     */
    public function getBookingTotal($roomId, DateTime $dateFrom, DateTime $dateTo)
    {
        $rooms = new Rooms();
        $room = $rooms->getFirst([
            'id' => $roomId,
        ]);

        $diff = $dateFrom->diff($dateTo);

        return $room->room_price * $diff->days;
    }

    /**
     * @param $roomId
     * @param $dateFrom
     * @param $dateTo
     * @param $userId
     * @return bool
     * @throws Exception
     */
    public function make($roomId, $dateFrom, $dateTo, $userId)
    {
        try {
            $total = $this->authoriseBookingAndGetTotal($roomId, $dateFrom, $dateTo);

            return $this->insert([
                'room_id' => $roomId,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'user_id' => $userId,
                'price_paid' => $total,
            ]);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}