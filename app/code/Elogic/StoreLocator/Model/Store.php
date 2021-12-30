<?php

declare(strict_types=1);

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
     * @return int|string
     */
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
     * @param string $store_name
     * @return StoreInterface
     */
    public function setName(string $store_name): StoreInterface
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
     * @param string|array $store_image
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
     * @param string $store_schedule
     * @return StoreInterface
     */
    public function setSchedule(string $store_schedule): StoreInterface
    {
        $this->setData(self::STORE_SCHEDULE, $store_schedule);
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->getData(self::STORE_ADDRESS);
    }

    /**
     * @param string $store_address
     * @return StoreInterface
     */
    public function setAddress(string $store_address): StoreInterface
    {
        $this->setData(self::STORE_ADDRESS, $store_address);
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getData(self::STORE_DESCRIPTION);
    }

    /**
     * @param string $store_description
     * @return StoreInterface
     */
    public function setDescription(string $store_description): StoreInterface
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
     * @param string $store_latitude
     * @return StoreInterface
     */
    public function setLatitude(string $store_latitude): StoreInterface
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
     * @param string $store_longitude
     * @return StoreInterface
     */
    public function setLongitude(string $store_longitude): StoreInterface
    {
        $this->setData(self::STORE_LONGITUDE, $store_longitude);
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->getData(self::STORE_URL_KEY);
    }

    /**
     * @param string $store_url_key
     * @return StoreInterface
     */
    public function setUrl(string $store_url_key): StoreInterface
    {
        $this->setData(self::STORE_URL_KEY, $store_url_key);
        return $this;
    }

    /**
     * @param string $store_url_key
     * @return StoreInterface
     */
    public function checkUrlKey(string $store_url_key): StoreInterface
    {
        return $this->_resource->checkUrlKey($store_url_key);
    }
}
