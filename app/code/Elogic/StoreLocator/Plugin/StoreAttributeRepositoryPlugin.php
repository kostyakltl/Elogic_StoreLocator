<?php

namespace Elogic\StoreLocator\Plugin;

use Elogic\StoreLocator\Model\ResourceModel\StoreAttribute;

/**
 * This plugin check if value is existing and return it
 */
class StoreAttributeRepositoryPlugin
{
    /**
     * @var StoreAttribute
     */
    private $storeAttribute;

    /**
     * @param StoreAttribute $storeAttribute
     */
    public function __construct(
        StoreAttribute $storeAttribute
    ) {
        $this->storeAttribute = $storeAttribute;
    }

    /**
     * @param $subject
     * @param $storeAttributes
     * @return array|null
     */
    public function beforeSave($subject, $storeAttributes)
    {
        try {
            $attributes = $this->storeAttribute->checkUnique($storeAttributes);
            $storeAttributes->setId($attributes['store_value_id']);
            return [$storeAttributes];
        } catch (\Exception $exception) {
            return null;
        }
    }
}
