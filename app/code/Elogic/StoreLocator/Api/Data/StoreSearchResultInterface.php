<?php

namespace Elogic\StoreLocator\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface StoreSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get stores list.
     *
     * @return \Magento\Store\Api\Data\StoreInterface[]
     */
    public function getItems();

    /**
     * Set stores list.
     *
     * @param \Magento\Store\Api\Data\StoreInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
