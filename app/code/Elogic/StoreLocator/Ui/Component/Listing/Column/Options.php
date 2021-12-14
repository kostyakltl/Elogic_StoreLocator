<?php

namespace Elogic\StoreLocator\Ui\Component\Listing\Column;

use Elogic\StoreLocator\Model\ResourceModel\Store\CollectionFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreAttribute;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;


class Options extends Column
{

    private $storeManager;
    private $collectionFactory;
    private $options;
    private $storeAttribute;
    private $resourceModel;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
        StoreManagerInterface $storeManager,
        CollectionFactory $collectionFactory,
        StoreAttribute $storeAttribute
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
        $this->storeAttribute = $storeAttribute;
        $this->collectionFactory = $collectionFactory;
    }


    /**
     * @param array $
     * @return array|void
     */
    public function prepareDataSource(array $dataSource)
    {
        $storeId = $this->storeManager->getStore(
            $this->context->getFilterParam(
                Store::STORE_ID, Store::DEFAULT_STORE_ID)
        )
            ->getId();
        if(isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                    $storeEntityId = $item['store_entity_id'];
                    $value = $this->storeAttribute->getAttributeValue($storeEntityId, $storeId, $fieldName);
                    $value = $value['value'];    //TODO говнокод бля, функція вертає ім'я в масиві, треба зробити, шоб нормально вертало, но мені щас впадлу
                    $this->setData($fieldName, $value);
                    $item[$fieldName] = $value;
            }
        }
        return $dataSource;
    }


}
