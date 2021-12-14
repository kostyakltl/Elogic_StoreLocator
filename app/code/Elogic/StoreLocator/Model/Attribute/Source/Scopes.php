<?php

namespace Elogic\StoreLocator\Model\Attribute\Source;

use Magento\Framework\Data\OptionSourceInterface;
use \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class Scopes implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            [
                'value' => ScopedAttributeInterface::SCOPE_STORE,
                'label' => __('Store View'),
            ],
            [
                'value' => ScopedAttributeInterface::SCOPE_WEBSITE,
                'label' => __('Web Site'),
            ],
            [
                'value' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'label' => __('Global'),
            ],
        ];
    }

}
