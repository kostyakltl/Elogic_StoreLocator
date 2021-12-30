<?php

declare(strict_types=1);

namespace Elogic\StoreLocator\Api\Data;

/**
 * Interface of Attribute model
 *
 */
interface StoreAttributeInterface
{
    /**
     * primary key
     */
    const ID = 'store_value_id';

    /**
     * attribute`s id
     * 1    -   name
     * 2    -   schedule
     */
    const ATTRIBUTE_ID = 'store_attribute_id';

    /**
     * id of store model
     */
    const ENTITY_ID = 'store_entity_id';

    /**
     * attribute value
     */
    const ATTRIBUTE_VALUE = 'value';

    /**
     * store view id
     */
    const SCOPE_ID = 'store_id';

    /**
     * @return int|string
     */
    public function getId();

    /**
     * @param int $value_id
     * @return StoreAttributeInterface
     */
    public function setId(int $value_id) : StoreAttributeInterface;

    /**
     * @return int
     */
    public function getAttrId() : int;

    /**
     * @param int $attribute_id
     * @return StoreAttributeInterface
     */
    public function setAttrId(int $attribute_id) : StoreAttributeInterface;

    /**
     * @return string
     */
    public function getValue() : string;

    /**
     * @param string $value
     * @return StoreAttributeInterface
     */
    public function setValue(string $value) : StoreAttributeInterface;

    /**
     * @return int
     */
    public function getStoreEntityId(): int;

    /**
     * @param int $entity_id
     * @return StoreAttributeInterface
     */
    public function setStoreEntityId(int $entity_id) : StoreAttributeInterface;

    /**
     * @return int
     */
    public function getScopeId();

    /**
     * @param int|string $scope_id
     * @return StoreAttributeInterface
     */
    public function setScopeId($scope_id) : StoreAttributeInterface;

    /**
     * @param int $storeEntityId
     * @param int $storeId
     * @param string $attributeCode
     * @return mixed
     */
    public function getAttributeValue(int $storeEntityId, int $storeId, string $attributeCode);
}
