<?php

namespace Dev\Banner\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
class Delete extends Action
{
    /**
     * @var \Dev\Banner\Model\Post
     */
    protected $modelBlog;
    /**
     * @param Context                  $context
     * @param \Dev\Banner\Model\Post $blogFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Dev\Banner\Model\Post $blogFactory
    ) {
        parent::__construct($context);
        $this->modelBlog = $blogFactory;
    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('banner_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->modelBlog;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Record deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['banner_id' => $id]);
            }
        }
        $this->messageManager->addError(__('Record does not exist.'));
        return $resultRedirect->setPath('*/*/');
    }
}
