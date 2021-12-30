<?php

namespace Elogic\StoreLocator\Observer;

use Elogic\StoreLocator\Api\Data\StoreAttributeInterface;
use Elogic\StoreLocator\Api\StoreAttributeRepositoryInterface;
use Elogic\StoreLocator\Model\ResourceModel\StoreAttribute as AttributeResource;
use Gt\Dom\Attr;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SaveAttributes implements ObserverInterface
{
    /**
     * @var StoreAttributeInterface
     */
    private $storeAttribute;
    /**
     * @var StoreAttributeRepositoryInterface
     */
    private $storeAttributeRepository;

    /**
     * @var AttributeResource
     */
    private $attributeResource;

    /**
     * @param StoreAttributeInterface $storeAttribute
     * @param StoreAttributeRepositoryInterface $storeAttributeRepository
     */
    public function __construct(
        StoreAttributeInterface $storeAttribute,
        StoreAttributeRepositoryInterface $storeAttributeRepository,
        AttributeResource $attributeResource
    ) {
        $this->storeAttribute = $storeAttribute;
        $this->storeAttributeRepository = $storeAttributeRepository;
        $this->attributeResource = $attributeResource;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $data = $observer->getData('store');
        if (isset($data['store_name'])) {
            $attr = $this->storeAttribute->setStoreEntityId($data['store_entity_id'])
                ->setAttrId(1)
                ->setScopeId(0)
                ->setValue($data['store_name']);
            if ($this->attributeResource->checkUnique($attr) == null) {
                $this->storeAttributeRepository->save($attr);
            }
        }
        if (isset($data['store_schedule'])) {
            $attr = $this->storeAttribute->setStoreEntityId($data['store_entity_id'])
                ->setAttrId(1)
                ->setScopeId(0)
                ->setValue($data['store_name']);
            if ($this->attributeResource->checkUnique($attr) == null) {
                $this->storeAttributeRepository->save($attr);
            }
            $this->storeAttributeRepository->save($attr);
        }
    }
}
