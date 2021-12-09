<?php

namespace Elogic\StoreLocator\Controller\Index;

use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Elogic\StoreLocator\Api\StoreRepositoryInterface;
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

    public function __construct(
        PageFactory $pageFactory,
        RequestInterface $request,
        StoreInterfaceFactory $storeFactory,
        StoreRepositoryInterface $storeRepository
    )
    {
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

        $store = $this->request->getParam('store');

        $page = $this->pageFactory->create();
        if($store !== null) {
            $name = $store->getName();
        }
        else {
            $page->getConfig()->getTitle()->prepend('No such store');
            return $page;
        }
//        $page->setHeader('name', $name);
//        $page->getConfig()->getTitle()->prepend($name);
        $page->getConfig()->setMetaTitle($name);
        return $page;
    }
}
