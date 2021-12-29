<?php

namespace Elogic\StoreLocator\Controller\Adminhtml\Store;

use Elogic\StoreLocator\Api\Data\StoreInterface;
use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Elogic\StoreLocator\Api\Data\StoreAttributeInterfaceFactory;
use Elogic\StoreLocator\Api\StoreAttributeRepositoryInterface;
use Elogic\StoreLocator\Api\GeoCoderInterface;
use Elogic\StoreLocator\Ui\DataProvider\StoreDataProvider;
use Magento\Catalog\Model\ImageUploader;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Save store entity controller
 */
class Save extends Action
{

    /**
     * @var RedirectFactory
     */
    private $redirectFactory;
    /**
     * @var StoreInterfaceFactory
     */
    private $storeFactory;
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;
    /**
     * @var ImageUploader
     */
    private $imageUploader;
    /**
     * @var Json
     */
    private $json;
    /**
     * @var GeoCoderInterface
     */
    private $geocoder;
    /**
     * @var StoreAttributeInterfaceFactory
     */
    private $storeAttributeFactory;
    /**
     * @var StoreAttributeRepositoryInterface
     */
    private $storeAttributeRepository;
    /**
     * @var StoreDataProvider
     */
    private $dataProvider;

    /**
     * @param Context $context
     * @param RedirectFactory $redirectFactory
     * @param StoreInterfaceFactory $storeFactory
     * @param StoreRepositoryInterface $storeRepository
     * @param ImageUploader $imageUploader
     * @param Json $json
     * @param GeoCoderInterface $geoCoder
     * @param StoreManagerInterface $storeManager
     * @param StoreAttributeInterfaceFactory $storeAttributeInterfaceFactory
     * @param StoreAttributeRepositoryInterface $storeAttributeRepository
     * @param StoreDataProvider $dataProvider
     */
    public function __construct(
        Context $context,
        RedirectFactory $redirectFactory,
        StoreInterfaceFactory $storeFactory,
        StoreRepositoryInterface $storeRepository,
        ImageUploader $imageUploader,
        Json $json,
        GeoCoderInterface $geoCoder,
        StoreAttributeInterfaceFactory $storeAttributeInterfaceFactory,
        StoreAttributeRepositoryInterface $storeAttributeRepository,
        StoreDataProvider $dataProvider
    )
    {
        parent::__construct($context);
        $this->storeFactory = $storeFactory;
        $this->storeRepository = $storeRepository;
        $this->storeAttributeFactory = $storeAttributeInterfaceFactory;
        $this->storeAttributeRepository = $storeAttributeRepository;
        $this->geocoder = $geoCoder;
        $this->json = $json;
        $this->imageUploader = $imageUploader;
        $this->redirectFactory = $redirectFactory;
        $this->dataProvider = $dataProvider;
    }

    /**
     * @throws LocalizedException
     * @throws \Exception
     */
    public function execute()
    {
        $redirectResult = $this->redirectFactory->create();
        $store = $this->storeFactory->create();
        $data = $this->getRequest()->getPostValue();

        $storeId = $data['store_id'];

        if (!$data['store_entity_id'])
            $data['store_entity_id'] = null;
        else
            $store->setId($data['store_entity_id']);

        $store->setName($data['store_name']);
        $store->setDescription($data['store_description']);
        $store->setAddress($data['store_address']);
        $this->setImage($data, $store);
        $this->setSchedule($data, $store);
        $this->setCoordinates($data, $store);
        $this->storeRepository->save($store);
        $this->setUrl($data, $store);
        $this->setAttributes($store, $data, $storeId);

        $redirectResult->setPath('*/*/index');
        return $redirectResult;
    }

    /**
     * @param $data
     * @param $store
     * @return mixed
     * @throws \Exception
     */
    public function setUrl($data, $store)
    {
        if($data['store_url_key']) {
            try {
                $store->setUrl($data['store_url_key']);
                $this->storeRepository->save($store);
            } catch (\Exception $exception) {       //unique check
                $this->messageManager->addErrorMessage(__('Url key is not unique\n Please edit it'));
            }
        }
        else {
            try {
                $store->setUrl(str_replace(' ', '-', strtolower($data['store_name'])));
                $this->storeRepository->save($store);
            } catch (\Exception $exception) {       //unique check
                $store->setUrl(str_replace(' ', '-', strtolower($data['store_name']) . '-' . random_int(0, 100)));
                $this->storeRepository->save($store);
            }
        }
        return $store;
    }

    /**
     * @param $data
     * @param $store
     * @return mixed
     */
    public function setCoordinates($data, $store)
    {
        if ($data['store_latitude'] == '' && $data['store_longitude'] == '') {
            $this->getCoordinates($data['store_address'], $store);
        } else {
            $store->setLatitude($data['store_latitude']);
            $store->setLongitude($data['store_longitude']);
        }
        return $store;
    }

    /**
     * @param $address
     * @param $store
     * @return mixed
     */
    public function getCoordinates($address, $store)
    {
        $coordinates = $this->geocoder->getCoordinatesByAddress($address);
        if ($coordinates == 'ErrorApi') {
            $this->messageManager->addErrorMessage(__('Api key is not correct.'));
        }
        elseif ($coordinates[0] == null || $coordinates[1] == null || $coordinates == 'ZERO_RESULTS') {
            $this->messageManager->addNoticeMessage(__('Address is not correct. Cant define coordinates.'));
        }
        else {
            $store->setLatitude($coordinates[1]);
            $store->setLongitude($coordinates[0]);
        }
        return $store;
    }

    /**
     * @param $data
     * @param $store
     * @return StoreInterface
     * @throws LocalizedException
     */
    public function setImage($data, $store): StoreInterface
    {
        if (isset($data['store_image'][0]['name']) && isset($data['store_image'][0]['tmp_name'])) {
            $data['store_image'] = $data['store_image'][0]['name'];
            $this->imageUploader->moveFileFromTmp($data['store_image']);
        } elseif (isset($data['store_image'][0]['name']) && !isset($data['store_image'][0]['tmp_name'])) {
            $data['store_image'] = $data['store_image'][0]['name'];
        } else {
            $data['store_image'] = '';
        }
        $store->setImage($data['store_image']);
        return $store;
    }

    /**
     * @param $data
     * @param $store
     * @return StoreInterface
     */
    public function setSchedule($data, $store): StoreInterface
    {
        if (isset($data['store_schedule'])) {
            $store->setSchedule($this->json->serialize($data['store_schedule']));
        }
        return $store;
    }

    /**
     * @param $store
     * @param $data
     * @param $storeId
     * @return void
     */
    public function setAttributes($store, $data, $storeId)
    {
        $storeAttribute = $this->storeAttributeFactory->create();
        $entityId = $store->getId();
        $attrlist = $storeAttribute->getAttributes();
        foreach ($data as $item) {
            foreach ($attrlist as $attr) {
                if ($item == $attr) {
                    $attributeId = $storeAttribute->resource->getAttributeIdByCode($attr);
                }
            }
        }
        if (sizeof($storeId) > 1) {
            foreach ($storeId as $item) {
                $storeId = $item;
                $this->setAttributeData($entityId, $data, $storeId);
            }
        }
        elseif(sizeof($storeId) ) {    // value = 0 if was set all store views
            $this->setAttributeData($entityId, $data, $storeId[0]);
        }
    }

    /**
     * @param $entityId
     * @param $data
     * @param $storeId
     * @return void
     */
    public function setAttributeData($entityId, $data, $storeId)
    {
        $storeAttribute = $this->storeAttributeFactory->create();
        $storeAttribute->setStoreEntityId($entityId);
        $storeAttribute->setScopeId($storeId);
        $storeAttribute->setAttrId(1);  //name
        $value = $data['store_name'];
        $storeAttribute->setValue($value);
        $this->storeAttributeRepository->save($storeAttribute);

        if (isset($data['store_schedule'])) {
            $storeAttribute = $this->storeAttributeFactory->create();
            $storeAttribute->setStoreEntityId($entityId);
            $storeAttribute->setScopeId($storeId);
            $storeAttribute->setAttrId(2); // schedule
            if (($data['store_schedule']) !== '') {
                $value = $this->json->serialize($data['store_schedule']);
            }
            $storeAttribute->setValue($value);
            $this->storeAttributeRepository->save($storeAttribute);
        }
    }
}
