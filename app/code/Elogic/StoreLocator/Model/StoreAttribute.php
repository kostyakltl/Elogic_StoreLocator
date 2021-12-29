<?php

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
     * @return array|mixed|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }


    /**
     * @param int $value_id
     * @return StoreAttributeInterface|mixed
     */
    public function setID($value_id) : StoreAttributeInterface
    {
        $this->setData(self::ID,$value_id);
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
     * @return $this
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
     * @return $this
     */
    public function setValue(string $value): StoreAttribute
    {
        $this->setData(self::ATTRIBUTE_VALUE, $value);
        return $this;
    }

    /**
     * @return array|mixed|null
     */
    public function getStoreEntityId()
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
     * @return int
     */
    public function getScopeId() : int
    {
        return $this->getData(self::SCOPE_ID);
    }

    /**
     * @param int $scope_id
     * @return $this
     */
    public function setScopeId(int $scope_id): StoreAttribute
    {
        $this->setData(self::SCOPE_ID, $scope_id);
        return $this;
    }

    /**
     * @param $storeEntityId int
     * @param $storeId int
     * @param $attributeCode string
     * @return mixed|bool|null
     */
    public function getAttributeValue(int $storeEntityId, int $storeId, string $attributeCode)
    {
        return $this->_resource->getAttributeValue($storeEntityId, $storeId, $attributeCode);
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->_resource->getAttributes();
    }
}
