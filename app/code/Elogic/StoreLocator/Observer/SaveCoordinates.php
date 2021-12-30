<?php

namespace Elogic\StoreLocator\Observer;

use Elogic\StoreLocator\Model\Source\GeoCoder;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SaveCoordinates implements ObserverInterface
{
    /**
     * @var GeoCoder
     */
    private $geoCoder;

    /**
     * @param GeoCoder $geoCoder
     */
    public function __construct(GeoCoder $geoCoder)
    {
        $this->geoCoder = $geoCoder;
    }

    /**
     * Define coordinates by address
     * @param Observer $observer
     * @return array|mixed|void|null
     */
    public function execute(Observer $observer)
    {
        $store = $observer->getData('store');
        $data = $store->getData();
        try {
            if ($data['store_latitude'] !== "" || $data['store_longitude'] !== "") {
                return $store;
            }
        } catch (\Exception $exception) {
            $address = $store->getAddress();
            $coordinates = $this->geoCoder->getCoordinatesByAddress($address);
            $store->setLatitude($coordinates[1]);
            $store->setLongitude($coordinates[0]);
            return $store;
        }
    }
}
