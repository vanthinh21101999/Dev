<?php

namespace Dev\Banner\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dev\Banner\Model\Post', 'Dev\Banner\Model\ResourceModel\Post');
    }

}