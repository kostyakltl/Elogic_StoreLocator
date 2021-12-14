<?php

namespace Elogic\StoreLocator\Model\ResourceModel;


use Elogic\StoreLocator\Api\Data\StoreInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\DB\Select;
use Magento\Eav\Model\ResourceModel\Attribute;

/**
 *
 */
class Store extends AbstractDb
{
    /**
     * Name of entity table
     */
    const ENTITY_TABLE_NAME = 'elogic_store_entity';
    /**
     * Name of table value of attributes
     */
    const VALUE_TABLE_NAME = 'elogic_store_value';
    /**
     * Name of table with attributes
     */
    const ATTRIBUTE_TABLE_NAME = 'elogic_store_attribute';

    /**
     * @return StoreInterface
     */
    protected function _construct()
    {
        $this->_init(self::ENTITY_TABLE_NAME, StoreInterface::STORE_ID);
    }

    public function checkUrlKey($url)
    {
        $select = $this->loadByUrlKey($url);
        $select->reset(Select::COLUMNS)
            ->columns('elogic_store_st.store_id')
            ->limit(1);

        return $this->getConnection()->fetchRow($select);
    }


    public function loadByUrlKey($url)
    {
        $select = $this->getConnection()->select()
            ->from(['elogic_store_entity' => $this->getMainTable()])
            ->where('elogic_store_entity.store_url_key = ?', $url);

        return $select;
    }

    //TODO function get attributeIdByCode   (код має получатись автоматично з назви колонки)

}
