<?php

namespace Elogic\StoreLocator\Api;

use Elogic\StoreLocator\Api\Data\StoreInterface;
use Elogic\StoreLocator\Api\Data\StoreSearchResultInterface;

interface StoreRepositoryInterface
{
    /**
     * @param StoreInterface $store
     * @return StoreInterface
     */
    public function save(StoreInterface $store);

    /**
     * @param StoreInterface $store
     * @return void
     */
    public function delete(StoreInterface $store);

    /**
     * @param int $store_id
     * @return void
     */
    public function deleteById(int $store_id);

    /**
     * @param int $store_id
     * @return StoreInterface
     */
    public function getById(int $store_id): StoreInterface;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return StoreSearchResultInterface
     */
    public function getList($searchCriteria);
}
