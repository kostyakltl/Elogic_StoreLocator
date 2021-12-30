<?php

declare(strict_types=1);

namespace Elogic\StoreLocator\Block;

use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Serialize\Serializer\Json;

class Store extends Template
{
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;
    /**
     * @var Context
     */
    private $context;
    /**
     * @var Json $json
     */
    private $json;

    /**
     * @param Context $context
     * @param StoreRepositoryInterface $storeRepository
     * @param Json $json
     */
    public function __construct(
        Context $context,
        StoreRepositoryInterface $storeRepository,
        Json $json
    ) {
        $this->storeRepository = $storeRepository;
        $this->context = $context;
        $this->json = $json;
        parent::__construct($context);
    }


    /**
     * @return mixed|null
     */
    public function getStore()
    {
        $store = $this->getRequest()->getParams();
        if (is_null($store)) {
            return null;
        }
        return $store['store'];
    }

    /**
     * @param $store
     * @return string|void
     */
    public function unserializeSchedule($store)
    {
        try {
            $schedule = $this->json->unserialize($store->getSchedule());
            foreach ($schedule as & $temp) {
                if (!isset($tmp)) {
                    $tmp = "day \"" . $temp['day'] . "\" - from \"" . $temp['from'] . "\" to \"" . $temp['to'] . "\", <br/> ";
                } else {
                    $tmp = $tmp . "day \"" . $temp['day'] . "\" - from \"" . $temp['from'] . "\" to \"" . $temp['to'] . "\" <br/>";
                }
            }
            return $tmp;
        } catch (\Exception $exception) {

        }
    }
}
