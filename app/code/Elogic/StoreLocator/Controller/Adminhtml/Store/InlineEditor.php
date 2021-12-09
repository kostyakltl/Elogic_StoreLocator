<?php

namespace Elogic\StoreLocator\Controller\Adminhtml\Store;

use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class InlineEditor extends Action
{

    private $jsonFactory;
    private $storeRepository;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        StoreRepositoryInterface $storeRepository
    )
    {
        $this->storeRepository = $storeRepository;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->jsonFactory->create();

        $data = $this->getRequest()->getParam('store_id', []);
        foreach (array_keys($data) as $storeId) {
            $store = $this->storeRepository->getById($storeId);
            $store->setData(array_merge($store->getData(), $data[$storeId]));
            $this->storeRepository->save($store);
        }
    }

}
