<?php

namespace Elogic\StoreLocator\Api;
use Elogic\StoreLocator\Api\Data\StoreInterface;

/**
 *
 */
interface StoreRepositoryInterface
{

    /**
     * @param StoreInterface $store
     * @return mixed
     */
    public function save(StoreInterface $store);

    /**
     * @param \ELogic\StoreLocator\Api\Data\StoreInterface $store
     * @return void
     */
    public function delete(StoreInterface $store);

    /**
     * @param $id
     * @return void
     */
    public function deleteById(int $store_id);

    /**
     * @param $store_id
     * @return StoreInterface
     */
    public function getById(int $store_id);

    /**
     * @param int $store_id
     * @return StoreInterface
     */
    public function getList(int $store_id);





}
