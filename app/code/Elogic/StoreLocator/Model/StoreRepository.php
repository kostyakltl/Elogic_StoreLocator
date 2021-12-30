<?php

declare(strict_types=1);

namespace Elogic\StoreLocator\Model;

use Elogic\StoreLocator\Api\Data\StoreInterface;
use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Elogic\StoreLocator\Model\ResourceModel\Store as Resource;
use Elogic\StoreLocator\Model\ResourceModel\Store\CollectionFactory;
use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Elogic\StoreLocator\Api\Data\StoreSearchResultInterface;
use Elogic\StoreLocator\Api\Data\StoreSearchResultInterfaceFactory;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Exception;

class StoreRepository implements StoreRepositoryInterface
{
    /**
     * @var StoreInterfaceFactory
     */
    private $storeFactory;
    /**
     * @var Resource
     */
    private $storeResource;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultFactory;
    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @param StoreInterfaceFactory $storeFactory
     * @param Resource $storeResource
     * @param CollectionFactory $collectionFactory
     * @param StoreSearchResultInterfaceFactory $searchResultsInterfaceFactory
     * @param EventManager $eventManager
     */
    public function __construct(
        StoreInterfaceFactory $storeFactory,
        Resource $storeResource,
        CollectionFactory $collectionFactory,
        StoreSearchResultInterfaceFactory $searchResultsInterfaceFactory,
        EventManager $eventManager
    ) {
        $this->storeFactory = $storeFactory;
        $this->collectionFactory = $collectionFactory;
        $this->storeResource = $storeResource;
        $this->searchResultFactory = $searchResultsInterfaceFactory;
        $this->eventManager = $eventManager;
    }

    /**
     * @param StoreInterface $store
     * @return StoreInterface
     * @throws AlreadyExistsException
     */
    public function save(StoreInterface $store) : StoreInterface
    {
        $this->eventManager->dispatch('storelocator_store_save_before', ['store' => $store]);
        $this->storeResource->save($store);
        return $store;
    }

    /**
     * @param StoreInterface $store
     * @return void
     * @throws Exception
     */
    public function delete(StoreInterface $store) : void
    {
        $this->storeResource->delete($store);
    }

    /**
     * @param int $store_id
     * @return void
     * @throws Exception
     */
    public function deleteById(int $store_id) : void
    {
        $store = $this->getById($store_id);
        $this->delete($store);
    }

    /**
     * @param int $store_id
     * @param int|null $storeView_id
     * @return string|StoreInterface $store
     */
    public function getById(int $store_id, int $storeView_id = null): StoreInterface
    {
        $store = $this->storeFactory->create();
        $this->storeResource->load($store, $store_id);
        return $store;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StoreSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria) : StoreSearchResultInterface
    {
        $collection = $this->collectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        /** @var StoreSearchResultInterface $searchResult */
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }
}
