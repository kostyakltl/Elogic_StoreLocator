<?php

namespace Elogic\StoreLocator\Model\ResourceModel\Store;

use Elogic\StoreLocator\Model\ResourceModel\Store as ResourceModel;
use Elogic\StoreLocator\Model\Store;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 *
 */
class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    public function _construct()
    {
       $this->_init(
           Store::class,
           ResourceModel::class
       );
    }
}
