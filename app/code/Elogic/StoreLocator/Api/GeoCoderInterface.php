<?php

namespace Elogic\StoreLocator\Api;

interface GeoCoderInterface
{
    public function getCoordinatesByAddress($address);
}
