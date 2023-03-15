<?php
namespace Dev\Banner\Block\Banner;

use Dev\Banner\Model\ResourceModel\Post\CollectionFactory;
class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        CollectionFactory $collectionFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function getCollectionFactory()
    {
        $collection = $this->collectionFactory->create();
        return $collection;
    }

}
