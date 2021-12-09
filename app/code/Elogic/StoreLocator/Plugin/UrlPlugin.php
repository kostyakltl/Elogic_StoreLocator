<?php

namespace Elogic\StoreLocator\Plugin;

use Elogic\StoreLocator\Api\Data\StoreInterface;
use Elogic\StoreLocator\Api\StoreRepositoryInterface;
use Elogic\StoreLocator\Controller\Adminhtml\Store\Save;
use Elogic\StoreLocator\Model\StoreRepository;
use Magento\Backend\App\Action;

class UrlPlugin
{
    protected $title;

   public function afterSaveUrl(
       $store
   )
   {
   }

}
