<?php

namespace Elogic\StoreLocator\Controller\Adminhtml\Store;

use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;

class Delete extends Action
{
    /**
     * @var RedirectFactory
     */
    protected $resultFactory;
    /**
     * @var
     */
    protected $resultRedirectFactory;
    /**
     * @var StoreInterfaceFactory
     */
    protected $storeFactory;
    /**
     * @var StoreRepositoryInterface
     */
    protected $storeRepository;

    /**
     * @param Context $context
     * @param StoreInterfaceFactory $storeFactory
     * @param StoreRepositoryInterface $storeRepository
     * @param RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        Context $context,
        StoreInterfaceFactory $storeFactory,
        StoreRepositoryInterface $storeRepository,
        RedirectFactory $resultRedirectFactory
    ) {
        $this->resultFactory = $resultRedirectFactory;
        $this->storeRepository = $storeRepository;
        $this->storeFactory = $storeFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('store_entity_id');
        $store = $this->storeRepository->getById($id);
        $this->storeRepository->delete($store);
        $this->messageManager->addSuccessMessage(__('Record have been deleted.'));
        $result = $this->resultRedirectFactory->create();
        $result->setPath('storelocator/store/index');

        return $result;
    }
}
