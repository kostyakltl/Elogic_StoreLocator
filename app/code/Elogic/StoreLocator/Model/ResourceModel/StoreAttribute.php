<?php

namespace Elogic\StoreLocator\Model\ResourceModel;

use Elogic\StoreLocator\Api\Data\StoreAttributeInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\DB\Select;

/**
 * Resource model of store`s attributes
 */
class StoreAttribute extends AbstractDb
{

    /**
     * Name of table value of attributes
     */
    const VALUE_TABLE_NAME = 'elogic_store_value';
    /**
     * Name of table with attributes
     */
    const ATTRIBUTE_TABLE_NAME = 'elogic_store_attribute';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::VALUE_TABLE_NAME, StoreAttributeInterface::ID);
    }

    /**
     * Return list of attributes
     * @return array
     */
    public function getAttributes()
    {
        $select = $this->getConnection()->select()
            ->from('elogic_store_attribute')
            ->columns('store_attribute_code');

        return $this->getConnection()->fetchPairs($select);
    }

    /**
     * Return attribute value by code
     * @param $entityId
     * @param $storeId
     * @param $attributeCode
     * @return mixed
     */
    public function getAttributeValue($entityId, $storeId, $attributeCode)
    {
        $attributeId = $this->getAttributeIdByCode($attributeCode);

        $select = $this->getConnection()->select()
            ->from([self::VALUE_TABLE_NAME])
            ->where(StoreAttributeInterface::ENTITY_ID. ' =?', $entityId)
            ->where(StoreAttributeInterface::SCOPE_ID . '= ?', $storeId)
            ->where(StoreAttributeInterface::ATTRIBUTE_ID . '=?', $attributeId);

        $select->reset(Select::COLUMNS)
            ->columns('value')
            ->limit(1);

        return $this->getConnection()->fetchRow($select);
    }

    /**
     * Return attribute id by code
     * @param $attributeCode
     * @return mixed
     */
    public function getAttributeIdByCode($attributeCode)
    {
        $select = $this->getConnection()->select()
            ->from(self::ATTRIBUTE_TABLE_NAME)
            ->where('store_attribute_code = ?', $attributeCode);
        $select->reset(Select::COLUMNS)
            ->columns('store_attribute_id')
            ->limit(1);

        return $this->getConnection()->fetchRow($select);
    }

    /**
     * If in attributes value table exist field with same parameters this function return it
     * @param StoreAttributeInterface $storeAttribute
     * @return array|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function checkUnique($storeAttribute)
    {
        $select = $this->getConnection()->select()
            ->from($this->getMainTable())
            ->where(StoreAttributeInterface::ATTRIBUTE_ID . '=?', $storeAttribute->getAttrId())
            ->where(StoreAttributeInterface::ENTITY_ID . '=?', $storeAttribute->getStoreEntityId())
            ->where(StoreAttributeInterface::SCOPE_ID . '=?', $storeAttribute->getScopeId());

        $select = $this->getConnection()->fetchRow($select);
        if ($select !== false) {
            return $select;
        } else {
            return null;
        }
    }
}
