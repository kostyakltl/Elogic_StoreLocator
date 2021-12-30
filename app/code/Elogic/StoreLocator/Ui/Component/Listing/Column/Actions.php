<?php

namespace Elogic\StoreLocator\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Elogic\StoreLocator\Api\Data\StoreInterface;

class Actions extends Column
{
    /**
     * Edit action path
     */
    const URL_PATH_EDIT = 'storelocator/store/edit';
    /**
     * Delete action path
     */
    const URL_PATH_DELETE = 'storelocator/store/delete';

    /**
     * @var UrlInterface
     */
    private $urlBuilder;
    /**
     * @var ContextInterface
     */
    protected $context;
    /**
     * @var UiComponentFactory
     */
    protected $uiComponentFactory;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->context = $context;
        $this->uiComponentFactory = $uiComponentFactory;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $storeId = $this->getData('store_entity_id');
        }
        foreach ($dataSource['data']['items'] as &$item) {
            $item[$this->getData('name')]['edit'] = [
               'href' => $this->urlBuilder->getUrl(
                   self::URL_PATH_EDIT,
                   [StoreInterface::STORE_ID => $item[StoreInterface::STORE_ID]]
               ),
               'label' => __('Edit'),
               'hidden' => false,
               ];
            $item[$this->getData('name')]['delete'] = [
                'href' => $this->urlBuilder->getUrl(
                    self::URL_PATH_DELETE,
                    [StoreInterface::STORE_ID => $item[StoreInterface::STORE_ID]]
                ),
                'label' => __('Delete'),
                'hidden' => false,
            ];
        }
        return $dataSource;
    }
}
