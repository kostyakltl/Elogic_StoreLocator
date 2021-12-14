<?php

declare(strict_types=1);

namespace Elogic\StoreLocator\Block;

use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Serialize\Serializer\Json;


class Store extends Template
{
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Context
     */
    private $context;

    /**
     * @var Json $json
     */
    private $json;

    /**
     * @param Context $context
     * @param ConfigProvider $configProvider
     * @param StoreRepositoryInterface $storeRepository
     * @param StoreManagerInterface $storeManager
     * @param Json $json
     */
    public function __construct(
        Context $context,
        StoreRepositoryInterface $storeRepository,
        Json $json
    ) {
        $this->storeRepository = $storeRepository;
        $this->context = $context;
        $this->json = $json;
        parent::__construct($context);
    }


    public function getStore()
    {
        $store = $this->getRequest()->getParams();
        if (is_null($store)) {
            return null;
        }
        return $store['store'];
    }




}
