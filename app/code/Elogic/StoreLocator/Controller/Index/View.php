<?php

namespace Elogic\StoreLocator\Controller\Index;

use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Elogic\StoreLocator\Model\ConfigProvider;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
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
    private $redirectFactory;

    /**
     * @param PageFactory $pageFactory
     * @param RequestInterface $request
     * @param StoreInterfaceFactory $storeFactory
     * @param StoreRepositoryInterface $storeRepository
     * @param ConfigProvider $configProvider
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        PageFactory $pageFactory,
        RequestInterface $request,
        StoreInterfaceFactory $storeFactory,
        StoreRepositoryInterface $storeRepository,
        ConfigProvider $configProvider,
        RedirectFactory $redirectFactory
    )
    {
        $this->redirectFactory = $redirectFactory;
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

        if($this->configProvider->isModuleEnable() ==  false) {
            return $this->redirectFactory->create()->setUrl('/');

        }
        $store = $this->request->getParam('store');

        if(!$store) {
            return $this->redirectFactory->create()->setPath('/');
        }
        if($store->getData() == null) {
            $page->getConfig()->getTitle()->prepend('No such store');
            return $page;
        }
        $name = $store->getName();
        $page->setHeader('name', $name);
        $page->getConfig()->getTitle()->prepend($name);
        return $page;
    }
}
