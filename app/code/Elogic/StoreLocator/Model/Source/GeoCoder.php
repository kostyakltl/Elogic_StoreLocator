<?php

namespace Elogic\StoreLocator\Model\Source;

use Elogic\StoreLocator\Api\GeoCoderInterface;
use Elogic\StoreLocator\Model\ConfigProvider;

class GeoCoder implements GeoCoderInterface
{
    private $configProvider;

    public function __construct(
        ConfigProvider $configProvider
    )
    {
        $this->configProvider = $configProvider;
    }

    public function getCoordinatesByAddress($address)
    {
        $apiKey = $this->configProvider->getGoogleMapsApiKey();
        $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='.$apiKey);
        if(strpos($geo, 'error_message')){
            $coordinates = 'ErrorApi';
        }
        elseif(strpos($geo, 'ZERO_RESULTS')) {
            $coordinates = 'ZERO_RESULTS';
        }
        else {
            $geo = json_decode($geo, true);
            if (isset($geo['status']) && ($geo['status'] == 'OK')) {
                $coordinates[0] = $geo['results'][0]['geometry']['location']['lat'];
                $coordinates[1] = $geo['results'][0]['geometry']['location']['lng'];
            }
        }
        return $coordinates;
    }
}
