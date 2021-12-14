<?php

namespace Elogic\StoreLocator\Model\ResourceModel;

use Elogic\StoreLocator\Api\Data\StoreAttributeInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class StoreAttribute extends AbstractDb
{
    const MAIN_TABLE = 'elogic_store_attribute';

    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, StoreAttributeInterface::ID);
    }

    public function getAttributeValue($entityId, $storeId, $attributeCode)
    {
        $attributeId = $this->getAttributeIdByCode($attributeCode);

        $select = $this->getConnection()->select()
            ->from([Store::VALUE_TABLE_NAME])
            ->where('store_entity_id = ?', $entityId)
            ->where('store_id = ?', $storeId)
            ->where('store_attribute_id = ?', $attributeId
            );

        $select->reset(Select::COLUMNS)
            ->columns('value')
            ->limit(1);

        return $this->getConnection()->fetchRow($select);
    }


    public function getAttributeIdByCode($attributeCode)
    {
        $select = $this->getConnection()->select()
            ->from(Store::ATTRIBUTE_TABLE_NAME)
            ->where('store_attribute_code = ?' , $attributeCode);
        $select->reset(Select::COLUMNS)
            ->columns('store_attribute_id')
            ->limit(1);

        return $this->getConnection()->fetchRow($select);
    }



}
