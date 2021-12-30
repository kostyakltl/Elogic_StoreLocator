<?php


namespace Elogic\StoreLocator\Controller\Adminhtml\Store;

use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Elogic\StoreLocator\Model\ResourceModel\Store\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;

class MassDelete extends Action
{

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param StoreRepositoryInterface $storeRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        StoreRepositoryInterface $storeRepository
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->storeRepository = $storeRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        foreach ($collection as $store) {
            $this->storeRepository->delete($store);
        }
        $this->messageManager->addSuccessMessage(__('Record(s) have been deleted.'));
        $this->_redirect("*/*/index");
    }
}
