<?php

namespace Elogic\StoreLocator\Plugin;

use Elogic\StoreLocator\Model\ResourceModel\StoreAttribute;

class StoreAttributeRepositoryPlugin
{

    private $storeAttribute;

    public function __construct(
        StoreAttribute $storeAttribute
    )
    {
        $this->storeAttribute = $storeAttribute;
    }

    public function beforeSave($subject, $storeAttributes)
    {
        try {
            $attributes = $this->storeAttribute->_checkUnique($storeAttributes);
            $storeAttributes->setId($attributes['store_value_id']);
            return [$storeAttributes];
        }
        catch (\Exception $exception) {
            return null;
        }
    }
}
