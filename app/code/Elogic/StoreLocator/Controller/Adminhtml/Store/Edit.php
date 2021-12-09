<?php

namespace Elogic\StoreLocator\Controller\Adminhtml\Store;

use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Magento\Backend\App\Action;
use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Magento\Framework\Registry;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $storeFactory;
    protected $storeRepository;
    protected $dataProvider;
    protected $coreRegistry;

    const ADMIN_RESOURCE = "Elogic_Store::store";

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        StoreInterfaceFactory $storeInterfaceFactory,
        StoreRepositoryInterface $storeRepository,
        Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->storeRepository = $storeRepository;
        $this->storeFactory = $storeInterfaceFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {

        $id = $this->getRequest()->getParam('store_id');
        $this->coreRegistry->register($id, $id);


        $store = $this->storeFactory->create();
        if($id) {
            $store = $this->storeRepository->getById($id);
            if(!$store->getId()) {
                $this->messageManager->addErrorMessage(__('No store with that id'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $store = $this->storeRepository->getById($id);

        $this->coreRegistry->register('store_id', $store);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Elogic_StoreLocator::storelocator');
        $resultPage->getConfig()->getTitle()->prepend(__('Store'));
        $resultPage->getConfig()->getTitle()->prepend($store->getName($id));
        $resultPage->addHandle('elogic_store' . $id);

        return $resultPage;
    }


}
