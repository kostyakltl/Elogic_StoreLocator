<?php
/*
 * Model of entity Store
 *
 */

namespace Elogic\StoreLocator\Model;


use Elogic\StoreLocator\Api\Data\StoreInterface;
use Elogic\StoreLocator\Model\ResourceModel\Store as ResourceModel;
use Magento\Framework\Model\AbstractModel;

/**
 * Model of entity Store
 *
 */
class Store extends AbstractModel implements StoreInterface
{

    /**
     *
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }



    public function getId()
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * @param int $store_id
     * @return StoreInterface
     */
    public function setId($store_id): StoreInterface
    {
        $this->setData(self::STORE_ID, $store_id);
        return $this;
    }


    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->getData(self::STORE_NAME);
    }

    /**
     * @param $store_name
     * @return StoreInterface
     */
    public function setName($store_name): StoreInterface
    {
        $this->setData(self::STORE_NAME, $store_name);
        return $this;
    }


    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->getData(self::STORE_IMAGE);
    }

    /**
     * @param $store_image
     * @return StoreInterface
     */
    public function setImage($store_image): StoreInterface
    {
        $this->setData(self::STORE_IMAGE, $store_image);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSchedule(): ?string
    {
        return $this->getData(self::STORE_SCHEDULE);
    }

    /**
     * @param $store_schedule
     * @return StoreInterface
     */
    public function setSchedule($store_schedule): StoreInterface
    {
        $this->setData(self::STORE_SCHEDULE, $store_schedule);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->getData(self::STORE_ADDRESS);
    }

    /**
     * @param $store_address
     * @return StoreInterface
     */
    public function setAddress($store_address): StoreInterface
    {
        $this->setData(self::STORE_ADDRESS, $store_address);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->getData(self::STORE_DESCRIPTION);
    }

    /**
     * @param $store_description
     * @return StoreInterface
     */
    public function setDescription($store_description): StoreInterface
    {
        $this->setData(self::STORE_DESCRIPTION, $store_description);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->getData(self::STORE_LATITUDE);
    }

    /**
     * @param $store_latitude
     * @return StoreInterface
     */
    public function setLatitude($store_latitude): StoreInterface
    {
        $this->setData(self::STORE_LATITUDE, $store_latitude);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongitude(): ?string
    {
        return $this->getData(self::STORE_LONGITUDE);
    }

    /**
     * @param $store_longitude
     * @return StoreInterface
     */
    public function setLongitude($store_longitude): StoreInterface
    {
        $this->setData(self::STORE_LONGITUDE, $store_longitude);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->getData(self::STORE_URL_KEY);
    }

    /**
     * @param $store_url_key
     * @return StoreInterface
     */
    public function setUrl($store_url_key): StoreInterface
    {
        $this->setData(self::STORE_URL_KEY, $store_url_key);
        return $this;
    }

    /**
     * @param $url
     * @return string|null
     */
    public function checkUrlKey($url): ?string
    {
        return $this->_resource->checkUrlKey($url);
    }

}
