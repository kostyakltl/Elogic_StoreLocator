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
        $storeId = $this->request->getParam('store', 0);
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);


        $items = $this->collection->getItems();
        foreach ($items as $store) {
            if ($store->getImage()) {
                $store->setImage([
                    [
                        'name' => $store->getImage(),
                        'url' => $mediaUrl . 'elogic/base_path/' . $store->getImage()
                    ]
                ]);
            }
            $name = $store->getName();
            if ($name == 'WARNING: No set name for this store view')
                $store->setName("");
            else
                $store->setName($name);
            $store->setData('store_view_id', $storeId);
            $this->loadedData[$store->getId()] = $store->getData();
        }
        return $this->loadedData;
    }
}
