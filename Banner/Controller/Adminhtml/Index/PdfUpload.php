<?php

namespace Dev\Banner\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

class PdfUpload extends \Magento\Backend\App\Action
{

    /**
     * @var \Dev\Banner\Model\PdfUploader
     */
    public $imageUploader;

    /**
     * Upload constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Dev\Banner\Model\PdfUploader $imageUploader
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Dev\Banner\Model\PdfUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * @return mixed
     */
    public function execute() {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('ffl');
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
