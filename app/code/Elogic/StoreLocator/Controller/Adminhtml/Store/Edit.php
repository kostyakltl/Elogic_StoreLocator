<?php

namespace Elogic\StoreLocator\Controller\Adminhtml\Store;

use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Magento\Backend\App\Action;
use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;

class Edit extends Action
{
    const ADMIN_RESOURCE = "Elogic_Store::store";

    protected $resultPageFactory;
    protected $storeFactory;
    protected $storeRepository;
    protected $dataProvider;
    protected $coreRegistry;
    private $storeManager;

    /**
     * @param Action\Context $context
     * @param StoreInterfaceFactory $storeInterfaceFactory
     * @param StoreRepositoryInterface $storeRepository
     * @param Registry $coreRegistry
     * @param StoreManagerInterface $storeManager
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        StoreInterfaceFactory $storeInterfaceFactory,
        StoreRepositoryInterface $storeRepository,
        Registry $coreRegistry,
        StoreManagerInterface $storeManager,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->storeRepository = $storeRepository;
        $this->storeFactory = $storeInterfaceFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->storeManager = $storeManager;
    }

    public function execute()
    {

        $id = $this->getRequest()->getParam('store_entity_id');
//        $this->coreRegistry->register($id, $id);

        $storeId = $this->getRequest()->getParam('store', 0);
        $store = $this->storeManager->getStore($storeId);
        $this->storeManager->setCurrentStore($store->getCode());

        $store = $this->storeFactory->create();
        if($id) {
            $store = $this->storeRepository->getById($id, $storeId);
            if(!$store->getId()) {
                $this->messageManager->addErrorMessage(__('No store with that id'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

//        $this->coreRegistry->register('store_entity_id', $store);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Elogic_StoreLocator::storelocator');
        $resultPage->getConfig()->getTitle()->prepend(__('Store'));
        $resultPage->addHandle('elogic_store_entity' . $id);

        return $resultPage;
    }


}
