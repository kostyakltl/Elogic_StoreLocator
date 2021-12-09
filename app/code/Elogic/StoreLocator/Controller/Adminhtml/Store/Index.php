<?php

namespace Elogic\StoreLocator\Controller\Adminhtml\Store;

use Elogic\StoreLocator\Model\ConfigProvider;
use Elogic\StoreLocator\Model\Source\GeoCoder;
use Magento\Backend\App\Action;

/**
 *  Index action
 */
class Index extends Action
{
    /**
     * @var bool|\Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory = false;
    /**
     * @var GeoCoder
     */
    protected $geoCoder;
    /**
     * @var ConfigProvider
     */
    protected $configProvider;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param GeoCoder $geoCoder
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        GeoCoder $geoCoder,
        ConfigProvider $configProvider
    )
    {
        $this->configProvider = $configProvider;
        $this->geoCoder = $geoCoder;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();

        if(!$this->configProvider->isModuleEnable()) {
            return __('Module is disabled');
        }
        else {

        $resultPage->setActiveMenu('Elogic_StoreLocator::storelocator');
        $resultPage->getConfig()->getTitle()->set(__("Stores"));
        $resultPage->getConfig()->getTitle()->prepend(__('Stores'));
        return $resultPage;
        }
    }


}
