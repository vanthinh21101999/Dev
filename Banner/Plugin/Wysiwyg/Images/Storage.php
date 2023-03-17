<?php

namespace Dev\Banner\Plugin\Wysiwyg\Images;

use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class Storage
 */
class Storage {


    protected $_settings;
    protected $_type;
    /**
     * @var \Magento\Framework\Module\Dir\Reader
     */
    private $moduleReader;
    /**
     * @var \Magento\Framework\Filesystem
     */
    private $filesystem;

    /**
     * Storage constructor.
     *
     * @param \Dev\Banner\Helper\Settings $helperSettings
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     * @param \Magento\Framework\Filesystem $filesystem
     */
    public function __construct(
        \Dev\Banner\Helper\Settings $helperSettings,
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magento\Framework\Filesystem $filesystem
    ){
        $this->_settings = $helperSettings;
        $this->moduleReader = $moduleReader;
        $this->filesystem = $filesystem;
    }

    public function beforeGetAllowedExtensions(
        \Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
                                                  $type
    ){
        $this->_type = $type;
    }


    public function afterGetAllowedExtensions(
        \Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
                                                  $result
    ){
        return array_merge($result,$this->_settings->getExtraFiletypes());
    }

    public function beforeResizeFile(
        \Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
                                                  $source,
                                                  $keepRatio = true
    ) {
        $sourceInfo = explode('.', $source);
        $fileExtension = end($sourceInfo);
        if (strtolower($fileExtension) == 'pdf') {
            $mediaPath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath() . 'pdf-icon.png';
            if (!file_exists($mediaPath)) {
                copy(
                    $this->moduleReader->getModuleDir(
                        \Magento\Framework\Module\Dir::MODULE_VIEW_DIR,
                        'Dev_Banner'
                    ) . '/adminhtml/web/images/pdf-icon.png',
                    $mediaPath
                );
            }
            $source = $mediaPath;
        }
        return [$source, $keepRatio];
    }
}
