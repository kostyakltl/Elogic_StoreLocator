<?php

declare(strict_types=1);

namespace Elogic\StoreLocator\Ui\DataProvider;

use Elogic\StoreLocator\Model\ResourceModel\Store\Collection;
use Elogic\StoreLocator\Model\ResourceModel\Store\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;

/**
 * Class StoreDataProvider
 * @package Elogic\Store\Ui\DataProvider
 */
class StoreDataProvider extends ModifierPoolDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    private $loadedData = [];

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Json
     */
    private $json;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param StoreManagerInterface $storeManager
     * @param Json $json
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        Json $json,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        $this->json = $json;
        $this->request = $request;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

    }

    /**
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData(): array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }
        $store = $this->request->getParam('store');
//        if (isset($store)) {
//            $this->collection->setId($store);
//        }
        $items = $this->collection->getItems();
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        foreach ($items as $store) {
            if ($store->getImage()) {
                $store->setImage([
                    [
                        'name' => $store->getImage(),
                        'url' => $mediaUrl . 'elogic/base_path/' . $store->getImage()
                    ]
                ]);
            }
            $schedule = $store->getSchedule();
            if ($schedule !== null) {
                $store->setSchedule($this->json->unserialize($schedule));
            } else {
                $store->setSchedule([]);
            }
            $this->loadedData[$store->getId()] = $store->getData();
        }

        $data = $this->dataPersistor->get('store');
        if (!empty($data)) {
            $store = $this->collection->getNewEmptyItem();
            $store->setData($data);
            $this->loadedData[$store->getId()] = $store->getData();
            $this->dataPersistor->clear('store');
        }

        return $this->loadedData;
    }
}
