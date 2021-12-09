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


    /**
     * @return array|mixed|null
     */
    public function getId()
    {
        return $this->getData('store_id');
    }

    /**
     * @param mixed $store_id
     * @return $this|Store|mixed
     */
    public function setId($store_id)
    {
        $this->setData('store_id', $store_id);
        return $this;
    }


    /**
     * @return array|mixed|null
     */
    public function getName()
    {
        return $this->getData('store_name');
    }

    /**
     * @param $store_name
     * @return $this|mixed
     */
    public function setName($store_name)
    {
        $this->setData('store_name', $store_name);
        return $this;
    }


    /**
     * @return array|mixed|null
     */
    public function getImage()
    {
        return $this->getData('store_image');
    }

    /**
     * @param $store_image
     * @return $this|mixed
     */
    public function setImage($store_image)
    {
        $this->setData('store_image', $store_image);
        return $this;
    }

    /**
     * @return array|mixed|null
     */
    public function getSchedule()
    {
        return $this->getData('store_schedule');
    }

    /**
     * @param $store_schedule
     * @return $this|mixed
     */
    public function setSchedule($store_schedule)
    {
        $this->setData('store_schedule', $store_schedule);
        return $this;
    }

    /**
     * @return array|mixed|null
     */
    public function getAddress()
    {
        return $this->getData('store_address');
    }

    /**
     * @param $store_address
     * @return $this|mixed
     */
    public function setAddress($store_address)
    {
        $this->setData('store_address', $store_address);
        return $this;
    }

    /**
     * @return array|mixed|null
     */
    public function getDescription()
    {
        return $this->getData('store_description');
    }

    /**
     * @param $store_description
     * @return $this|mixed
     */
    public function setDescription($store_description)
    {
        $this->setData('store_description', $store_description);
        return $this;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->getData('store_latitude');
    }

    /**
     * @param $store_latitude
     * @return StoreInterface
     */
    public function setLatitude($store_latitude)
    {
        $this->setData('store_latitude', $store_latitude);
        return $this;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->getData('store_longitude');
    }

    /**
     * @param $store_longitude
     * @return StoreInterface
     */
    public function setLongitude($store_longitude)
    {
        $this->setData('store_longitude', $store_longitude);
        return $this;
    }

    /**
     * @return array|mixed|null
     */
    public function getUrl()
    {
        return $this->getData('store_url_key');
    }

    /**
     * @param $store_url_key
     * @return StoreInterface
     */
    public function setUrl($store_url_key)
    {
        $this->setData('store_url_key', $store_url_key);
        return $this;
    }

    /**
     * @param $url
     * @return mixed
     */
    public function checkUrlKey($url)
    {
        return $this->_resource->checkUrlKey($url);
    }
}
