<?php

declare(strict_types=1);

namespace Elogic\StoreLocator\Api\Data;

interface StoreInterface
{
    /**
     * Constants defined for keys of the data array.
     */
    const STORE_ID                          = 'store_entity_id';
    const STORE_NAME                        = 'store_name';
    const STORE_DESCRIPTION                 = 'store_description';
    const STORE_IMAGE                       = 'store_image';
    const STORE_ADDRESS                     = 'store_address';
    const STORE_SCHEDULE                    = 'store_schedule';
    const STORE_LONGITUDE                   = 'store_longitude';
    const STORE_LATITUDE                    = 'store_latitude';
    const STORE_URL_KEY                     = 'store_url_key';

    /**
     * @return int|string
     */
    public function getId();

    /**
     * @param int $store_id
     * @return StoreInterface
     */
    public function setId(int $store_id): StoreInterface;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string $store_name
     * @return StoreInterface
     */
    public function setName(string $store_name): StoreInterface;

    /**
     * @return string|null
     */
    public function getDescription() :?string;

    /**
     * @param string $store_description
     * @return StoreInterface
     */
    public function setDescription(string $store_description): StoreInterface;

    /**
     * @return string|array|null
     */
    public function getImage(): ?string;

    /**
     * @param string|array $store_image
     * @return StoreInterface
     */
    public function setImage($store_image): StoreInterface;

    /**
     * @return string
     */
    public function getAddress(): string;

    /**
     * @param string $store_address
     * @return StoreInterface
     */
    public function setAddress(string $store_address): StoreInterface;

    /**
     * @return string|null
     */
    public function getSchedule(): ?string;

    /**
     * @param string $store_schedule
     * @return StoreInterface
     */
    public function setSchedule(string $store_schedule): StoreInterface;

    /**
     * @return string|null
     */
    public function getLongitude(): ?string;

    /**
     * @param string $store_longitude
     * @return StoreInterface
     */
    public function setLongitude(string $store_longitude): StoreInterface;

    /**
     * @return string|null
     */
    public function getLatitude(): ?string;

    /**
     * @param string $store_latitude
     * @return StoreInterface
     */
    public function setLatitude(string $store_latitude): StoreInterface;

    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @param string $store_url_key
     * @return StoreInterface
     */
    public function setUrl(string $store_url_key): StoreInterface;

    /**
     * return store by url key
     * @param string $store_url_key
     * @return StoreInterface
     */
    public function checkUrlKey(string $store_url_key): StoreInterface;
}
