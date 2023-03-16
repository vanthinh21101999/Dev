<?php

namespace Dev\Banner\Model;

use Dev\Banner\Model\ResourceModel\Post\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends AbstractDataProvider
{
    private array $loadedData = [];

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $movieCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        StoreManagerInterface $storeManager,
        CollectionFactory $movieCollectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $movieCollectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     * @return array
     */
    public function getData()
    {
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $data = $model->getData();
            if (isset($data['img']) && isset($data['ffl'])) {
                $this->loadedData[$model->getId()] = $model->getData();
                $m['img'][0]['name'] = $model->getImageField();
                $m['img'][0]['url'] = $this->getMediaUrl($data['img']);
                $m['ffl'][0]['name'] = $model->getImageField();
                $m['ffl'][0]['url'] = $this->getMediaUrl($data['ffl']);
                $fullData = $this->loadedData;
                $this->loadedData[$model->getId()] = array_merge($fullData[$model->getId()], $m);
            }
        }

        return $this->loadedData;
    }

    public function getMediaUrl($path = '')
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'wysiwyg/helloworld/' . $path;
        return $mediaUrl;
    }
}

