<?php

namespace Elogic\StoreLocator\Api;

use Elogic\StoreLocator\Api\Data\StoreAttributeInterface;

/**
 *
 */
interface StoreAttributeRepositoryInterface
{

    /**
     * @param StoreAttributeInterface $storeAttribute
     * @return StoreAttributeInterface
     */
    public function save($storeAttribute) : StoreAttributeInterface;

    /**
     * @param StoreAttributeInterface $storeAttribute
     * @return void
     */
    public function delete($storeAttribute) : void;

    /**
     * @param int $attributeId
     * @return void
     */
    public function deleteById(int $attributeId) :void;

    /**
     * @param int $attributeId
     * @return StoreAttributeInterface
     */
    public function getById(int $attributeId) : StoreAttributeInterface;
}
