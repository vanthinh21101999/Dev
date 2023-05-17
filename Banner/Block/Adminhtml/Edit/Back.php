<?php

namespace Dev\Banner\Block\Adminhtml\Edit;

use Dev\Banner\Block\Adminhtml\Edit\Button\Generic;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
class Back extends Generic implements ButtonProviderInterface
{
    /**
     * Get button data test
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10,
        ];
    }
    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('banner_admin/post/index');
    }
}
