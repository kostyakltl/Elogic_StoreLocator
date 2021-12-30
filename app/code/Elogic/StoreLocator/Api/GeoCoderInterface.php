<?php

namespace Elogic\StoreLocator\Api;

interface GeoCoderInterface
{
    /**
     * @param string $address
     * @return mixed
     */
    public function getCoordinatesByAddress(string $address);
}
