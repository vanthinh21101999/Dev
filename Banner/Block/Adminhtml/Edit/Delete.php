<?php

namespace Dev\Banner\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Dev\Banner\Block\Adminhtml\Edit\Button\Generic;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
class Delete extends Generic implements ButtonProviderInterface
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        $blog_id = $this->context->getRequest()->getParam('banner_id');
        if ($blog_id) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?'
                    ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }
    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        $banner_id = $this->context->getRequest()->getParam('banner_id');
        return $this->getUrl('*/post/delete', ['banner_id' => $banner_id]);
    }
}
