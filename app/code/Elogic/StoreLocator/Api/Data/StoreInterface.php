<?php

namespace Elogic\StoreLocator\Api\Data;


/**
 *
 */
interface StoreInterface
{
    /**
     *
     */
    const STORE_ID                          = 'store_id';
    const STORE_NAME                        = 'store_name';
    const STORE_DESCRIPTION                 = 'store_description';
    const STORE_IMAGE                       = 'store_image';
    const STORE_ADDRESS                     = 'store_address';
    const STORE_SCHEDULE                    = 'store_schedule';
    const STORE_LONGITUDE                   = 'store_longitude';
    const STORE_LATITUDE                    = 'store_latitude';
    const STORE_URL_KEY                     = 'store_url_key';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param $store_id
     * @return mixed
     */
    public function setId($store_id);

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param $store_name
     * @return mixed
     */
    public function setName($store_name);

    /**
     * @return mixed
     */
    public function getDescription();

    /**
     * @param $store_description
     * @return mixed
     */
    public function setDescription($store_description);

    /**
     * @return mixed
     */
    public function getImage();

    /**
     * @param $store_image
     * @return mixed
     */
    public function setImage($store_image);

    /**
     * @return string
     */
    public function getSchedule();

    /**
     * @param $store_schedule
     * @return mixed
     */
    public function setSchedule($store_schedule);

    /**
     * @return mixed
     */
    public function getLongitude();

    /**
     * @param $store_longitude
     * @return mixed
     */
    public function setLongitude($store_longitude);

    /**
     * @return mixed
     */
    public function getLatitude();

    /**
     * @param $store_latitude
     * @return mixed
     */
    public function setLatitude($store_latitude);

    /**
     * @return mixed
     */
    public function getUrl();

    /**
     * @param $store_url_key
     * @return mixed
     */
    public function setUrl($store_url_key);

    /**
     * @param $store_url_key
     * @return mixed
     */
    public function checkUrlKey($store_url_key);

}
