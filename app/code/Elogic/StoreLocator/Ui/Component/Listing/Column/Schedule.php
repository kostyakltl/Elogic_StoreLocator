<?php

namespace Elogic\StoreLocator\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Serialize\Serializer\Json;

class Schedule extends Column
{

    /**
     * @var Json
     */
    private $json;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Json $json
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Json $json,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->json = $json;
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                try {
                    $schedule = $this->json->unserialize($item['store_schedule']);
                    foreach ($schedule as & $temp) {
                        if (!isset($tmp)) {
                            $tmp = "day \"" . $temp['day'] . "\" - from \"" . $temp['from'] . "\" to \"" . $temp['to'] . "\",  ";
                        } else {
                            $tmp = $tmp . "day \"" . $temp['day'] . "\" - from \"" . $temp['from'] . "\" to \"" . $temp['to'] . "\" \r\n";
                        }
                        $item['store_schedule'] = $tmp;
                    }
                } catch (\Exception $exception) {

                }
            }
        }
        return $dataSource;
    }
}
