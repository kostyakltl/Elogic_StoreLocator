<?php
namespace Elogic\StoreLocator\Plugin;

class StoreRepositoryPlugin
{
    public function afterGetById($subject, $store, $storeId, $storeViewId = null)
    {
        if ($storeViewId == null) {
            return $store;
        }
        $store->setData('store_view_id', $storeViewId);
        $store->setName($store->getName());
        return $store;
    }
}
