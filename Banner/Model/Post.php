<?php

namespace Dev\Banner\Model;

use Dev\Banner\Api\Data\PostInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Post extends AbstractModel implements PostInterface, IdentityInterface
{
    const CACHE_TAG = 'examples_first_module_post';
    protected function _construct()
    {
        $this->_init('Dev\Banner\Model\ResourceModel\Post');
    }

    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getPostId()];
    }

    public function getBannerId(): int
    {
        return $this->getData(self::BANNER_ID);
    }

    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    public function getImg(): string
    {
        return $this->getData(self::IMG);
    }

    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    public function getShortDescription(): string
    {
        return $this->getData(self::SHORT_DESCRIPTION);
    }

    public function setBannerId(int $bannerId): PostInterface
    {
        return $this->setData(self::BANNER_ID, $bannerId);
    }

    public function setName(string $name): PostInterface
    {
        return $this->setData(self::NAME, $name);
    }

    public function setImg(string $img): PostInterface
    {
        return $this->setData(self::IMG, $img);
    }

    public function setStatus(string $status): PostInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    public function setShortDescription(string $shortDescription): PostInterface
    {
        return $this->setData(self::SHORT_DESCRIPTION, $shortDescription);
    }
}
