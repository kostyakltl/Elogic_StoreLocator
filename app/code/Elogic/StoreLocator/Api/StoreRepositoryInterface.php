<?php

declare(strict_types=1);

namespace Elogic\StoreLocator\Api;

use Elogic\StoreLocator\Api\Data\StoreInterface;
use Elogic\StoreLocator\Api\Data\StoreSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface StoreRepositoryInterface
{
    /**
     * @param StoreInterface $store
     * @return StoreInterface
     */
    public function save(StoreInterface $store): StoreInterface;

    /**
     * @param StoreInterface $store
     * @return void
     */
    public function delete(StoreInterface $store) : void;

    /**
     * @param int $store_id
     * @return void
     */
    public function deleteById(int $store_id) : void;

    /**
     * @param int $store_id
     * @param int|null $storeView_id
     * @return StoreInterface
     */
    public function getById(int $store_id, int $storeView_id=null): StoreInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StoreSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): StoreSearchResultInterface;
}
