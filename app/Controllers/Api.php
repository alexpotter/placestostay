<?php

namespace app\Controllers;
use app\Models\Api as ApiModel;
use app\Models\Location;

class Api extends Controller
{
    /**
     * @param $location
     * @throws \Exception
     */
    public function search($location)
    {
        $locations = new Location();

        $response = $locations->getWhereLike([
            'town' => $location
        ]);
        
        $this->returnJson([
            'response' => $response
        ], 200);
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

    /**
     * @param $error
     * @param $reason
     * @param $code
     */
    public function returnApiError($error, $reason, $code)
    {
        return $this->returnJson([
            'error' => $error,
            'reason' => $reason,
            'error_code' => $code,
        ], $code);
    }
    
    public function authenticate($key)
    {
        $api = new ApiModel();
        
        return sizeof($api->authenticateKey($key)) == 0 ? false : true;
    }
}