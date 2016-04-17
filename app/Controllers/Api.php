<?php

namespace app\Controllers;

class Api extends Controller
{
    public function search($params)
    {
        $this->returnJson(['search' => $params], 200);
    }

    /**
     * @param $id
     * @param $guests
     * @param $from
     * @param $to
     */
    public function book($id, $guests, $from, $to)
    {
        $this->returnJson([
            'booking_id' => 200,
            'location_id' => (int) $id,
            'guests' => (int) $guests,
            'total' => 200,
            'currency' => 'gbp',
            'dates' => [
                'from' => $from,
                'to' => $to,
            ],
        ], 200);
    }

    /**
     * @param $reason
     * @param $responseCode
     */
    public function returnFail($reason, $responseCode)
    {
        $this->returnJson([
            'status' => 'failed',
            'reason' => $reason,
            'responseCode' => $responseCode
        ], $responseCode);
    }
}