<?php

namespace Elogic\StoreLocator\Model;

use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Elogic\StoreLocator\Model\ResourceModel\Store as Resource;
use Elogic\StoreLocator\Model\ResourceModel\Store\CollectionFactory;
use Elogic\StoreLocator\Api\Data\StoreSearchResultInterfaceFactory;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Exception;

/**
 *
 */
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
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @param StoreInterfaceFactory $storeFactory
     * @param CollectionFactory $collectionFactory
     * @param Resource $storeResource
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
     * @param \Elogic\StoreLocator\Api\Data\StoreInterface $store
     * @return \Elogic\StoreLocator\Api\Data\StoreInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(\Elogic\StoreLocator\Api\Data\StoreInterface $store)
    {
        $this->storeResource->save($store);
        return $store;
    }

    /**
     * @param \Elogic\StoreLocator\Api\Data\StoreInterface $store
     * @return void
     * @throws Exception
     */
    public function delete(\Elogic\StoreLocator\Api\Data\StoreInterface $store)
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
     * @return \Elogic\StoreLocator\Api\Data\StoreInterface $store

     */
    public function getById($store_id)
    {
        $store = $this->storeFactory->create();
        $this->storeResource->load($store, $store_id);
        return $store;
    }


    /**
     * @param $searchCriteria
     * @return \Elogic\StoreLocator\Api\Data\StoreInterface
     */
    public function getList($searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }


}
