<?php

namespace Elogic\StoreLocator\Model;

use Elogic\StoreLocator\Api\Data\StoreInterface;
use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Elogic\StoreLocator\Model\ResourceModel\Store as Resource;
use Elogic\Storelocator\Model\ResourceModel\Store\Collection as StoreCollection;
use Elogic\StoreLocator\Model\ResourceModel\Store\CollectionFactory;
use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Elogic\StoreLocator\Api\Data\StoreSearchResultInterface;
use Elogic\StoreLocator\Api\Data\StoreSearchResultInterfaceFactory;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Exception;

/**
 *
 */
class   StoreRepository implements StoreRepositoryInterface
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
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @param StoreInterfaceFactory $storeFactory
     * @param Resource $storeResource
     * @param CollectionFactory $collectionFactory
     * @param StoreSearchResultInterfaceFactory $searchResultsInterfaceFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        StoreInterfaceFactory $storeFactory,
        Resource $storeResource,
        CollectionFactory $collectionFactory,
        StoreSearchResultInterfaceFactory $searchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->storeFactory = $storeFactory;
        $this->collectionFactory = $collectionFactory;
        $this->storeResource = $storeResource;
        $this->searchResultFactory = $searchResultsInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param StoreInterface $store
     * @return StoreInterface
     * @throws AlreadyExistsException
     */
    public function save(StoreInterface $store) : StoreInterface
    {
        $this->storeResource->save($store);
        return $store;
    }

    /**
     * @param StoreInterface $store
     * @return void
     * @throws Exception
     */
    public function delete(StoreInterface $store)
    {
        $this->storeResource->delete($store);
    }

    /**
     * @param int $store_id
     * @return void
     * @throws Exception
     */
    public function deleteById(int $store_id)
    {
        $store = $this->getById($store_id);
        $this->delete($store);
    }

    /**
     * @param int $store_id
     * @param int|null $storeView_id
     * @return string|StoreInterface $store
     */
    public function getById(int $store_id, int $storeView_id=null): StoreInterface
    {
        $store = $this->storeFactory->create();
        $this->storeResource->load($store, $store_id);
//        $store->setData('store_view_id', $storeView_id);
//        $store->setName(($store->getName()));
        return $store;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return StoreSearchResultInterface
     */
    public function getList($searchCriteria)
    {
        /** @var StoreCollection $collection */
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
