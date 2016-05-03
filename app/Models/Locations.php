<?php


namespace app\Models;

use Exception;

class Locations extends BaseModel
{
    protected $table = 'locations';

    /**
     * @param $name
     * @param $streetNumber
     * @param $addressLine1
     * @param $town
     * @param $postcode
     * @param $country
     * @param $googleId
     * @param $lat
     * @param $lng
     * @param $type
     * @return bool
     * @throws Exception
     */
    public function add($name, $streetNumber, $addressLine1, $town, $postcode, $country, $googleId, $lat, $lng, $type)
    {
        try {
            $this->insert([
                'name' => $name,
                'lat' => $lat,
                'lng' => $lng,
                'google_id' => $googleId,
                'street_number' => $streetNumber ?: 0,
                'address_line1' => $addressLine1,
                'town' => $town,
                'postcode' => $postcode,
                'country' => $country,
                'belongs_to' => $_SESSION['admin']->ID,
                'location_type' => $type
            ]);
        }
        catch (Exception $e) {
            throw $e;
        }

        return true;
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
     * @param $town
     * @return array
     * @throws Exception
     */
    public function getLocationsAndRoomsByTown($town)
    {
        $returnArray = [];

        $locations = $this->getWhereLike([
            'town' => $town
        ]);

        foreach ($locations as $location)
        {
            $roomsModel = new Rooms();
            $rooms = $roomsModel->get([
               'location_id' => $location->ID,
            ]);

            if ($rooms)
            {
                $location->rooms = [];
                foreach ($rooms as $room)
                {
                    $location->rooms[] = $room;
                }
            }

            $returnArray[] = $location;
        }

        return $returnArray;
    }
}