<?php

namespace Elogic\StoreLocator\Api\Data;

use Elogic\StoreLocator\Model\StoreAttribute;

interface StoreAttributeInterface
{
    /**
     *
     */
    const NAME = 'store_name';
    /**
     *
     */
    const SCHEDULE = 'store_schedule';

    const ID = 'store_value_id';

    /**
     * @param $name
     * @param $storeId
     * @return StoreAttributeInterface
     */
    public function setName($name, $storeId): StoreAttributeInterface;

    /**
     * @param $schedule
     * @param $storeId
     * @return StoreAttributeInterface
     */
    public function setSchedule($schedule, $storeId): StoreAttributeInterface;

    /**
     * @param $storeId
     * @return string
     */
    public function getName($storeId): string;

    /**
     * @param $storeId
     * @return string
     */
    public function getSchedule($storeId): string;


}
