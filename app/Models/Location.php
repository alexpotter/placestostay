<?php


namespace app\Models;


class Location extends BaseModel
{
    protected $table = 'locations';

    public function add($name, $streetNumber, $addressLine1, $town, $postcode, $country, $googleId, $lat, $lng)
    {
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
}