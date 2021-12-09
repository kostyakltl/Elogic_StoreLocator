<?php

namespace Elogic\StoreLocator\Model;

use Magento\Framework\File\Name;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class ImageUploader extends \Magento\Catalog\Model\ImageUploader
{
    const IMAGE_BASE_PATH = 'elogic/store';
    const IMAGE_BASE_TMP_PATH = 'elogic/tmp/store';

    public function __construct(
        Database $coreFileStorageDatabase,
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        $baseTmpPath,
        $basePath,
        $allowedExtensions,
        $allowedMimeTypes = [],
        Name $fileNameLookup = null
    )
    {
        parent::__construct($coreFileStorageDatabase, $filesystem, $uploaderFactory, $storeManager, $logger, $baseTmpPath, $basePath, $allowedExtensions, $allowedMimeTypes, $fileNameLookup);
    }
}
