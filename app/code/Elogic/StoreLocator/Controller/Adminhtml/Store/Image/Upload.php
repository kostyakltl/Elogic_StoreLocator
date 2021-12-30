<?php

namespace Elogic\StoreLocator\Controller\Adminhtml\Store\Image;

use Magento\Catalog\Model\ImageUploader;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\View\FileSystem;
use Magento\Store\Model\StoreManagerInterface;
use Exception;

class Upload extends Action
{

    protected $storeManager;
    protected $fileSystem;
    protected $imageUploader;

    public function __construct(
        Context $context,
        UploaderFactory $uploaderFactory,
        StoreManagerInterface $storeManager,
        FileSystem $fileSystem,
        ImageUploader $imageUploader
    ) {
        $this->imageUploader = $imageUploader;
        $this->storeManager = $storeManager;
        $this->fileSystem = $fileSystem;
        parent::__construct($context);
    }

    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'store_image');
        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
