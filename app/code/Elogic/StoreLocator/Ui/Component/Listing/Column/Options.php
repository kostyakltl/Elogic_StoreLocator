<?php

namespace Elogic\StoreLocator\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\App\Request\Http;

use Elogic\StoreLocator\Api\Data\StoreInterface;
use Elogic\StoreLocator\Model\ResourceModel\StoreAttribute as StoreAttributeResource;

class Options extends Column
{

    /**
     * @var StoreAttributeResource
     */
    private $storeAttributeResource;
    /**
     * @var Http
     */
    private $request;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     * @param Http $request
     * @param StoreAttributeResource $storeAttributeResource
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
        Http $request,
        StoreAttributeResource $storeAttributeResource
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->request = $request;
        $this->storeAttributeResource = $storeAttributeResource;
    }


    /**
     * @param array
     * @return array|void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        $fieldName = $this->storeAttributeResource->getAttributes();
        foreach ($fieldName as &$attr)
           $dataSource = $this->setAttributes($dataSource, $attr);
        return $dataSource;
    }


    /**
     * @param array $dataSource
     * @return array
     */
    public function setAttributes(array $dataSource, $attr)
    {
        $storeId = $this->getContext()->getFilterParam('elogic_store_attribute');
        if(isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $storeEntityId = $item[StoreInterface::STORE_ID];
                $value = $this->storeAttributeResource->getAttributeValue($storeEntityId, $storeId, $attr);
                if (!$value)
                    $value = 'WARNING: No set ' . str_replace('store_', ' ', $attr) . ' for this this scope';
                else
                    $value = $value['value'];
                $this->setData($attr, $value);
                $item[$attr] = $value;
            }
        }
        return $dataSource;
    }


}
