<?php

declare(strict_types=1);

namespace Elogic\StoreLocator\Model;

use Elogic\StoreLocator\Api\StoreAttributeRepositoryInterface;
use Elogic\StoreLocator\Api\Data\StoreAttributeInterfaceFactory;
use Elogic\StoreLocator\Api\Data\StoreAttributeInterface;
use Elogic\StoreLocator\Model\ResourceModel\StoreAttribute as ResourceModel;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Exception;

class StoreAttributeRepository implements StoreAttributeRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    private $storeAttributeResource;
    /**
     * @var StoreAttributeInterfaceFactory
     */
    private $storeAttributeFactory;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param ResourceModel $storeAttributeResource
     * @param StoreAttributeInterfaceFactory $storeAttributeFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceModel $storeAttributeResource,
        StoreAttributeInterfaceFactory $storeAttributeFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->storeAttributeResource = $storeAttributeResource;
        $this->storeAttributeFactory = $storeAttributeFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @param StoreAttributeInterface $storeAttribute
     * @return StoreAttributeInterface
     * @throws AlreadyExistsException
     */
    public function save(StoreAttributeInterface $storeAttribute) : StoreAttributeInterface
    {
//        if ($storeAttribute->getScopeId() == 0) { //if scope id = 0 - save for all store views
//            $storeList = $this->storeManager->getStores($withDefault= true);
//            foreach ($storeList as $item) {
//                $storeAttributeNew = $this->storeAttributeFactory->create();
//                $storeAttributeNew->setScopeId($item->getId());
//                $storeAttributeNew->setAttrId($storeAttribute->getAttrId());
//                $storeAttributeNew->setValue($storeAttribute->getValue());
//                $storeAttributeNew->setStoreEntityId($storeAttribute->getStoreEntityId());
//                $this->storeAttributeResource->save($storeAttributeNew);
//            }
//            return $storeAttribute;
//        }
        $this->storeAttributeResource->save($storeAttribute);
        return $storeAttribute;
    }

    /**
     * @param StoreAttributeInterface $storeAttribute
     * @return void
     * @throws Exception
     */
    public function delete(StoreAttributeInterface $storeAttribute) : void
    {
        $this->storeAttributeResource->delete($storeAttribute);
    }

    /**
     * @param int $attributeId
     * @return void
     * @throws Exception
     */
    public function deleteById(int $attributeId) : void
    {
        $storeAttribute = $this->getById($attributeId);
        $this->delete($storeAttribute);
    }

    /**
     * @param int $attributeId
     * @return StoreAttributeInterface
     */
    public function getById(int $attributeId) : StoreAttributeInterface
    {
        $storeAttribute = $this->storeAttributeFactory->create();
        $this->storeAttributeResource->load($storeAttribute, $attributeId);
        return $storeAttribute;
    }
}
