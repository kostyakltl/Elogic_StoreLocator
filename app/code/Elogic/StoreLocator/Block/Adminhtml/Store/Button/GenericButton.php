<?php

namespace Elogic\StoreLocator\Block\Adminhtml\Store\Button;

use Magento\Backend\Block\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 *
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var
     */
    protected $customform;


    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @return void|null
     */
    public function getStoreId()
    {
        try
        {
            $this->context->getRequest()->getParam('store_id');
        }
        catch (NoSuchEntityException $e)
        {
            return null;
        }
    }

    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

}
