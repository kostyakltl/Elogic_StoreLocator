<?php

namespace Elogic\StoreLocator\Controller;

use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Url;
use Elogic\StoreLocator\Model\ConfigProvider;
use Exception;

class Router implements RouterInterface
{
    private $response;
    private $actionFactory;
    private $storeFactory;
    private $storeRepository;
    private $configProvider;

    public function __construct(
        ActionFactory            $actionFactory,
        ResponseInterface        $response,
        StoreInterfaceFactory    $storeInterfaceFactory,
        StoreRepositoryInterface $storeRepository,
        ConfigProvider           $configProvider
    )
    {
        $this->storeRepository = $storeRepository;
        $this->storeFactory = $storeInterfaceFactory;
        $this->actionFactory = $actionFactory;
        $this->response = $response;
    }

    public function match(RequestInterface $request)
    {
        $urlKey = trim($request->getPathInfo(), '/');
        $url = explode('/', $urlKey);
        if (strpos($urlKey, 'storess') !== false) {
            $request->setModuleName('storess');
            $request->setControllerName('index');
            $request->setActionName('view');
            if(isset($url[1])) {
                $store = $this->storeFactory->create();
                $storeId = $store->checkUrlKey($url[1]);
                if ($storeId !== "") {
                    $store = $this->storeRepository->getById($storeId);
                }
                $request->setParams([
                'store' => $store,
                ]);
            }
            else {
                return $this->actionFactory->create(Forward::class);
            }
        }
        return $this->actionFactory->create(Forward::class, ['request' => $request]);
    }
}

