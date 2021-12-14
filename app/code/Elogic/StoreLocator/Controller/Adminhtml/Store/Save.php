<?php

namespace Elogic\StoreLocator\Controller\Adminhtml\Store;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Serialize\Serializer\Json;
use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Elogic\StoreLocator\Api\Data\StoreInterfaceFactory;
use Elogic\StoreLocator\Api\GeoCoderInterface;
use Magento\Store\Model\StoreManagerInterface;
use function PHPUnit\Framework\isEmpty;
use function Symfony\Component\String\s;

class Save extends Action
{

    private $redirectFactory;
    private $storeFactory;
    private $storeRepository;
    private $imageUploader;
    private $json;
    private $geocoder;
    private $storeManager;

    public function __construct(
        Context $context,
        RedirectFactory $redirectFactory,
        StoreInterfaceFactory $storeFactory,
        StoreRepositoryInterface $storeRepository,
        ImageUploader $imageUploader,
        Json $json,
        GeoCoderInterface $geoCoder,
        StoreManagerInterface $storeManager
    )
    {
        $this->storeManager = $storeManager;
        $this->geocoder = $geoCoder;
        $this->json = $json;
        $this->imageUploader = $imageUploader;
        $this->redirectFactory = $redirectFactory;
        $this->storeFactory = $storeFactory;
        $this->storeRepository = $storeRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $redirectResult = $this->redirectFactory->create();
        $store = $this->storeFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data['store_entity_id']) {
            $data['store_entity_id'] = null;
        }
        else {
            $store->setId($data['store_entity_id']);
        }

        $storeViewId = $this->storeManager->getStore()->getId();


        $store->setName($data['store_name']);
        $store->setDescription($data['store_description']);

        //image save
        if (isset($data['store_image'][0]['name']) && isset($data['store_image'][0]['tmp_name'])) {
            $data['store_image'] =$data['store_image'][0]['name'];
            $this->imageUploader->moveFileFromTmp($data['store_image']);
        } elseif (isset($data['store_image'][0]['name']) && !isset($data['store_image'][0]['tmp_name'])) {
            $data['store_image'] = $data['store_image'][0]['image'];
        } else {
            $data['store_image'] = null;
        }
        $store->setImage($data['store_image']);

        //save schedule
        if(isset($data['store_schedule'])) {
            $store->setSchedule($this->json->serialize($data['store_schedule']));
        }

        //save address
        $store->setAddress($data['store_address']);
        $this->saveUrl($store);

        //save coordinates
        if($data['store_latitude'] == '' && $data['store_longitude'] == '') {
            $this->saveCoordinates($data['store_address'], $store);
        }
        else {
            $store->setLatitude($data['store_latitude']);
            $store->setLongitude($data['store_longitude']);
        }
        $this->storeRepository->save($store);

        $redirectResult->setPath('*/*/index');
        return $redirectResult;
    }

    public function saveUrl($store)
    {
        $this->storeRepository->save($store);
        $store->setUrl(str_replace(' ', '-', strtolower($store->getName())));
    }


    public function saveCoordinates($address, $store)
    {
        //save coordinates
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
    }
}
