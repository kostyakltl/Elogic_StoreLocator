<?php

namespace Elogic\StoreLocator\ViewModel;

use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Url\Helper\Data as UrlHelper;

class StoreViewModel implements ArgumentInterface
{

    private $storeRepository;
    private $urlHelper;
    private $storeFactory;

    public function __construct(
        StoreRepositoryInterface $storeRepository,
        StoreInterfaceFactory $storeInterfaceFactory,
        UrlHelper $urlHelper

    )
    {
        $this->storeFactory = $storeInterfaceFactory;
        $this->urlHelper = $urlHelper;
        $this->storeRepository = $storeRepository;
    }

    public function getStore(string $url, array $data = []) : array
    {
        $store = $this->storeFactory->create();
        $url = $store->checkUrlKey();
        return $url;
    }
}

