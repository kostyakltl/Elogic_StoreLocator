<?php

declare(strict_types=1);

namespace Elogic\StoreLocator\Model;

use Elogic\StoreLocator\Api\Data\StoreAttributeInterface;
use Elogic\StoreLocator\Model\ResourceModel\StoreAttribute as ResourceModel;
use Magento\Framework\Model\AbstractModel;

/**
 * Model of store attributes
 */
class StoreAttribute extends AbstractModel implements StoreAttributeInterface
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @param int $value_id
     * @return StoreAttributeInterface
     */
    public function setId($value_id) : StoreAttributeInterface
    {
        $this->setData(self::ID, $value_id);
        return $this;
    }

    /**
     * @return int
     */
    public function getAttrId() : int
    {
        return $this->getData(self::ATTRIBUTE_ID);
    }

    /**
     * @param int $attribute_id
     * @return StoreAttributeInterface
     */
    public function setAttrId(int $attribute_id): StoreAttribute
    {
        $this->setData(self::ATTRIBUTE_ID, $attribute_id);
        return $this;
    }

    /**
     * @return string
     */
    public function getValue() : string
    {
        return $this->getData(self::ATTRIBUTE_VALUE);
    }

    /**
     * @param string $value
     * @return StoreAttributeInterface
     */
    public function setValue(string $value): StoreAttribute
    {
        $this->setData(self::ATTRIBUTE_VALUE, $value);
        return $this;
    }

    /**
     * @return int
     */
    public function getStoreEntityId(): int
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @param int $entity_id
     * @return StoreAttributeInterface
     */
    public function setStoreEntityId(int $entity_id): StoreAttributeInterface
    {
        $this->setData(self::ENTITY_ID, $entity_id);
        return $this;
    }

    /**
     * @return int|string
     */
    public function getScopeId()
    {
        return $this->getData(self::SCOPE_ID);
    }

    /**
     * @param int|string $scope_id
     * @return StoreAttributeInterface
     */
    public function setScopeId($scope_id): StoreAttribute
    {
        $this->setData(self::SCOPE_ID, $scope_id);
        return $this;
    }

    /**
     * @param int $storeEntityId
     * @param int $storeId
     * @param string $attributeCode
     * @return string|array|null
     */
    public function getAttributeValue(int $storeEntityId, int $storeId, string $attributeCode)
    {
        return $this->_resource->getAttributeValue($storeEntityId, $storeId, $attributeCode);
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->_resource->getAttributes();
    }
}
