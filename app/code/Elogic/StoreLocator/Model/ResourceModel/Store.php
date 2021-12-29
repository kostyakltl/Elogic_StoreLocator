<?php

namespace Elogic\StoreLocator\Model\ResourceModel;


use Elogic\StoreLocator\Api\Data\StoreInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\DB\Select;

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
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::ENTITY_TABLE_NAME, StoreInterface::STORE_ID);
    }

    /**
     * Return store entity id by url key
     * @param $url
     * @return string
     */
    public function checkUrlKey($url)
    {
        $select = $this->loadByUrlKey($url);
        $select->reset(Select::COLUMNS)
            ->columns(StoreInterface::STORE_ID)
            ->limit(1);

        return $this->getConnection()->fetchOne($select);
    }

    public function checkUniqueUrl($url)
    {
        $select = $this->getConnection()->select()
            ->from([self::ENTITY_TABLE_NAME])
            ->where(StoreInterface::STORE_URL_KEY . '= ?', $url);
//
//        $select->reset(Select::COLUMNS)
//            ->columns(StoreInterface::STORE_ID)
//            ->limit(1);

        if($this->getConnection()->fetchOne($select) == false) {
            return false;
        }
        return true;
    }

    /**
     * @param $url
     * @return Select
     */
    public function loadByUrlKey($url)
    {
        $select = $this->getConnection()->select()
            ->from([self::ENTITY_TABLE_NAME])
            ->where(StoreInterface::STORE_URL_KEY . '= ?', $url);

        return $select;
    }

}
