<?php
namespace Dev\Banner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Download extends Action
{
    public $blogFactory;

    public function __construct(
        Context $context,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Filesystem\DirectoryList $directory,
        \Dev\Banner\Model\PostFactory $blogFactory
    ) {
        $this->blogFactory = $blogFactory;
        $this->_downloader = $fileFactory;
        $this->directory = $directory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        try {
            $blogModel = $this->blogFactory->create();
            $blogModel->load($id);
                if ($blogModel['ffl']) {
                    $file = $this->directory->getPath("media").'/wysiwyg/helloworld/'. $blogModel['ffl'];
                }
            return $this->_downloader->create(
                $blogModel['ffl'],
                @file_get_contents($file)
            );
            $this->messageManager->addSuccessMessage(__('You downloaded the pdf file.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect->setPath('*/*/');
    }
}
