<?php

namespace Elogic\StoreLocator\Controller\Adminhtml\Store;

use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;

class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var StoreInterfaceFactory
     */
    protected $storeFactory;
    /**
     * @var StoreRepositoryInterface
     */
    protected $storeRepository;
    /**
     * @var
     */
    protected $dataProvider;
    /**
     * @var
     */
    protected $coreRegistry;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param Action\Context $context
     * @param StoreInterfaceFactory $storeInterfaceFactory
     * @param StoreRepositoryInterface $storeRepository
     * @param StoreManagerInterface $storeManager
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        StoreInterfaceFactory $storeInterfaceFactory,
        StoreRepositoryInterface $storeRepository,
        StoreManagerInterface $storeManager,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->storeRepository = $storeRepository;
        $this->storeFactory = $storeInterfaceFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->storeManager = $storeManager;
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $storeViewId = $this->getRequest()->getParam('store', 0);
        $storeView = $this->storeManager->getStore($storeViewId);
        $this->storeManager->setCurrentStore($storeView->getCode());

        $storeId = $this->getRequest()->getParam('store_entity_id');
        if ($storeId) {
            $store = $this->storeRepository->getById($storeId, $storeViewId);
            if (!$store->getId()) {
                $this->messageManager->addErrorMessage(__('No store with that id'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Elogic_StoreLocator::storelocator');
        $resultPage->getConfig()->getTitle()->prepend(__('Store'));
        $resultPage->addHandle('elogic_store_entity' . $storeId);
        return $resultPage;
    }
}
