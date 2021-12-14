<?php
declare(strict_types=1);

namespace Elogic\StoreLocator\Model;

use Elogic\StoreLocator\Api\Data\StoreAttributeInterface;
use Elogic\StoreLocator\Model\ResourceModel\StoreAttribute as ResourceModel;

use Magento\Framework\Model\AbstractModel;

class StoreAttribute extends AbstractModel implements StoreAttributeInterface
{
    public function __construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function setName($name, $storeId): StoreAttributeInterface
    {
        $this->setData(self::NAME, $storeId);
        return $this;
    }

    public function setSchedule($schedule, $storeId): StoreAttributeInterface
    {
        $this->setData(self::SCHEDULE, $storeId);
        return $this;
    }

    public function getName($storeId): string
    {
        return $this->getData(self::NAME, $storeId);
    }

    public function getSchedule($storeId): string
    {
        return $this->getData(self::SCHEDULE, $storeId);
    }

}
