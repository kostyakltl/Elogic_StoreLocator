<?php

namespace Elogic\StoreLocator\Api\Data;

use Magento\Framework\Api\Search\SearchResultInterface;

interface StoreSearchResultInterface extends SearchResultInterface
{
    public function setItems(array $items = null);

    public function getItems();

}
