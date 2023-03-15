<?php

namespace Dev\Banner\Model;

use Dev\Banner\Api\Data\PostInterface;
use Dev\Banner\Api\Data\PostInterfaceFactory;
use Dev\Banner\Api\Data\PostSearchResultsInterface;
use Dev\Banner\Api\Data\PostSearchResultsInterfaceFactory;
use Dev\Banner\Api\PostRepositoryInterface;
use Dev\Banner\Model\ResourceModel\Post as ResourcePost;
use Dev\Banner\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Post repository
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PostRepository implements PostRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var ResourcePost
     */
    private $resource;
    /**
     * @var PostCollectionFactory
     */
    private $collectionFactory;
    /**
     * @var PostFactory
     */
    private $postFactory;
    /**
     * @var PostInterfaceFactory
     */
    private $postInterfaceFactory;
    /**
     * @var PostSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @param ResourcePost $resource
     * @param PostFactory $postFactory
     * @param PostInterfaceFactory $postInterfaceFactory
     * @param PostCollectionFactory $collectionFactory
     * @param PostSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourcePost                      $resource,
        PostFactory                       $postFactory,
        PostInterfaceFactory              $postInterfaceFactory,
        PostCollectionFactory             $collectionFactory,
        PostSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface      $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->postFactory = $postFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->postInterfaceFactory = $postInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $bannerId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $bannerId): bool
    {
        return $this->delete($this->getById($bannerId));
    }

    /**
     * @param PostInterface $post
     * @return bool
     */
    public function delete(PostInterface $post): bool
    {
        try {
            $this->resource->delete($post);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the post: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * @param int $bannerId
     * @return PostInterface
     */
    public function getById(int $bannerId): PostInterface
    {
        $post = $this->postFactory->create();
        $this->resource->load($post, $bannerId);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('The post with the "%1" ID doesn\'t exist.', $bannerId));
        }

        return $post;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return PostSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param PostInterface $post
     * @return PostInterface
     * @throws CouldNotSaveException
     */
    public function save(PostInterface $post): PostInterface
    {
        try {
            $this->resource->save($post);
        } catch (LocalizedException $exception) {
            throw new CouldNotSaveException(
                __('Could not save the post: %1', $exception->getMessage()),
                $exception
            );
        } catch (\Throwable $exception) {
            throw new CouldNotSaveException(
                __('Could not save the post: %1', __('Something went wrong while saving the post.')),
                $exception
            );
        }
        return $post;
    }
}
