<?php

namespace app\Controllers;
use app\Models\Api as ApiModel;
use app\Models\Locations;
use Exception;

class Api extends Controller
{
    /**
     * @param $town
     * @param $from
     * @param $to
     */
    public function search($town, $from = null, $to = null)
    {
        $locationsModel = new Locations();

        try {
            $locations = $locationsModel->getLocationsAndRoomsByTown($town, $from, $to);
        }
        catch (Exception $e) {
            return $this->returnJson([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong',
            ], 400);
        }

        if (empty($locations))
        {
            return $this->returnApiError('Locations not found', 'No locations exist within the town specified', 404);
        }
        
        return $this->returnJson([
            'locations' => $locations,
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