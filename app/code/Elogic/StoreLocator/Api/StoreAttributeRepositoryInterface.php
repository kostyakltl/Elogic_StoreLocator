<?php

namespace Elogic\StoreLocator\Api;

use Elogic\StoreLocator\Api\Data\StoreAttributeInterface;

interface StoreAttributeRepositoryInterface
{
    /**
     * @param StoreAttributeInterface $storeAttribute
     * @return mixed
     */
    public function save(StoreAttributeInterface $storeAttribute);


}
