<?php


namespace app\Models;


use Exception;

class Location extends BaseModel
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
     * @return bool
     * @throws Exception
     */
    public function add($name, $streetNumber, $addressLine1, $town, $postcode, $country, $googleId, $lat, $lng)
    {
        try {
            $this->insert([
                'name' => $name,
                'lat' => $lat,
                'lng' => $lng,
                'google_id' => $googleId,
                'street_number' => $streetNumber,
                'address_line1' => $addressLine1,
                'town' => $town,
                'postcode' => $postcode,
                'country' => $country,
                'belongs_to' => $_SESSION['admin']['ID']
            ]);
        }
        catch (Exception $e) {
            throw $e;
        }

        return true;
    }
}