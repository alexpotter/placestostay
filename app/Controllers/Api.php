<?php

namespace app\Controllers;
use app\Models\Api as ApiModel;
use app\Models\Bookings;
use app\Models\Locations;
use app\Models\Rooms;
use Exception;

class Api extends Controller
{
    /**
     * @param $town
     * @param $from
     * @param $to
     * @param null $locationType
     */
    public function search($town, $from = null, $to = null, $locationType = null)
    {
        $locationsModel = new Locations();

        try {
            $locations = $locationsModel->getLocationsAndRoomsByTown($town, $from, $to, $locationType);
        }
        catch (Exception $e) {
            return $this->returnJson([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong',
                'errorCode' => 400,
            ], 400);
        }

        if (empty($locations))
        {
            return $this->returnApiError('Locations not found', 'No locations match search criteria', 404);
        }
        
        return $this->returnJson([
            'locations' => $locations,
        ], 200);
    }

    /**
     * @param $roomId
     * @param $from
     * @param $to
     */
    public function book($roomId, $from, $to, $userId)
    {
        $booking = new Bookings();
        
        try {
            $response = $booking->make($roomId, $from, $to, $userId);
        }
        catch (Exception $e) {
            return $this->returnJson([
                'error' => $e->getMessage(),
                'message' => 'Booking failed',
                'errorCode' => 400,
            ], 400);
        }

        return $this->returnJson([
            'message' => 'Booking successfully created',
            'booking' => $booking->getBooking($response),
        ], 200);
    }

    /**
     * @param $reason
     * @param $responseCode
     */
    public function returnFail($reason, $responseCode)
    {
        $this->returnJson([
            'error' => 'Something went wrong',
            'message' => $reason,
            'errorCode' => $responseCode,
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
            'message' => $reason,
            'error_code' => $code,
        ], $code);
    }

    /**
     * @param $key
     * @return bool
     * @throws Exception
     */
    public function authenticate($key)
    {
        $api = new ApiModel();
        
        return sizeof($api->authenticateKey($key)) == 0 ? false : true;
    }
}