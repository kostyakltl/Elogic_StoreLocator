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
     *
     */
    const TABLE_NAME = 'elogic_store';

    /**
     * @return StoreInterface
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, StoreInterface::STORE_ID);
    }

    public function checkUrlKey($url)
    {
        $select = $this->loadByUrlKey($url);
        $select->reset(Select::COLUMNS)
            ->columns('elogic_store.store_id')
            ->limit(1);

        return $this->getConnection()->fetchRow($select);
    }


    public function loadByUrlKey($url)
    {
        $select = $this->getConnection()->select()
            ->from(['elogic_store' => $this->getMainTable()])
            ->where('elogic_store.store_url_key = ?', $url);

        return $select;
    }

}
