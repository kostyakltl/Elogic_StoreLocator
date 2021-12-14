<?php

namespace Elogic\StoreLocator\Controller\Index;

use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Elogic\StoreLocator\Model\ConfigProvider;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;
use Exception;

class View implements HttpGetActionInterface
{

    private $pageFactory;
    private $request;
    private $storeFactory;
    private $storeRepository;
    private $configProvider;

    public function __construct(
        PageFactory $pageFactory,
        RequestInterface $request,
        StoreInterfaceFactory $storeFactory,
        StoreRepositoryInterface $storeRepository,
        ConfigProvider $configProvider
    )
    {
        $this->configProvider = $configProvider;
        $this->storeRepository = $storeRepository;
        $this->storeFactory = $storeFactory;
        $this->pageFactory = $pageFactory;
        $this->request = $request;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $page = $this->pageFactory->create();

//        if($this->configProvider->isModuleEnable() ==  false) {
//            return $page->
//        }

        $store = $this->request->getParam('store');
        if($store !== null) {
            $name = $store->getName();
        }
        else {
            $page->getConfig()->getTitle()->prepend('No such store');
            return $page;
        }

        $page->setHeader('name', $name);
        $page->getConfig()->getTitle()->prepend($name);
        $page->getConfig()->setMetaTitle($name);
        return $page;
    }
}
