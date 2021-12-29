<?php

namespace Elogic\StoreLocator\Plugin;

use Elogic\StoreLocator\Model\Store;
use Elogic\StoreLocator\Api\Data\StoreAttributeInterfaceFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * This plugins returns attribute depending on attributes
 */
class StoreAttributesGetter
{

    private $storeManager;
    /**
     * @var StoreAttributeInterfaceFactory
     */
    private $storeAttributeFactory;
    /**
     * @var Http
     */
    private $request;

    /**
     * @param StoreAttributeInterfaceFactory $storeAttributeInterfaceFactory
     * @param Http $request
     */
    public function __construct(
        StoreAttributeInterfaceFactory $storeAttributeInterfaceFactory,
        Http $request,
        StoreManagerInterface $storeManager
    )
    {
        $this->storeManager = $storeManager;
        $this->request = $request;
        $this->storeAttributeFactory = $storeAttributeInterfaceFactory;
    }

    /**
     * @param Store $store
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function afterGetName(Store $store) : ?string
    {
        $id = $store->getId();
        $storeId = $this->request->getParam('store', 0) ?? $store->getData('store_view_id');
        if (is_object($storeId))
            $storeId = $this->storeManager->getStore()->getId();
        $storeAttribute = $this->storeAttributeFactory->create();
        if ($id !== null) {
            $name = $storeAttribute->getAttributeValue($id, $storeId, 'store_name');
            if ($name == false)
                return 'WARNING: No set name for this store view';
            else
                return $name['value'];
        }
        return null;
    }

    /**
     * @param Store $store
     * @return string|void|null
     */
    public function afterGetSchedule(Store $store)
    {
        $id = $store->getId();
        $storeId = $this->request->getParam('store', 0) ?? $store->getData('store_view_id');
        if (is_object($storeId))
            $storeId = $this->storeManager->getStore()->getId();
        $storeAttribute = $this->storeAttributeFactory->create();
        if($id!== null) {
            $schedule = $storeAttribute->getAttributeValue($id, $storeId, 'store_schedule');
            if($schedule == false)
                return null;
            else
                return $schedule['value'];
        }
    }
}
