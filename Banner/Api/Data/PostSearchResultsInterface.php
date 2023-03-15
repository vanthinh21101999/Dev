<?php

namespace Dev\Banner\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PostSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get post list.
     *
     * @return PostInterface[]
     */
    public function getItems(): array;

    /**
     * Set post list.
     *
     * @param PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
