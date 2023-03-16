<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: MageDelight Pvt. Ltd.
 */
namespace Dev\Banner\Controller\Adminhtml\Form;

use Magento\Backend\App\Action;
use Magento\Backend\Model\Session;
use Dev\Banner\Model\Post;
use Dev\Banner\Model\PostFactory;
use Dev\Banner\Model\ImageUploader;
use Magento\MediaStorage\Model\File\UploaderFactory;
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @var Post
     */
    protected $uiExamplemodel;
    /**
     * @var Session
     */
    protected $adminsession;

    /**
     * @param PostFactory $postFactory
     * @param Action\Context $context
     * @param Post $uiExamplemodel
     * @param Session $adminsession
     * @param UploaderFactory $uploaderFactory
     */
    public function __construct(
        Action\Context $context,
        Post           $uiExamplemodel,
        ImageUploader  $imageUploaderModel,
        PostFactory    $postFactory,
        UploaderFactory $uploaderFactory,
        Session        $adminsession
    )
    {
        parent::__construct($context);
        $this->postFactory = $postFactory;
        $this->uiExamplemodel = $uiExamplemodel;
        $this->imageUploaderModel = $imageUploaderModel;
        $this->adminsession = $adminsession;
        $this->uploaderFactory = $uploaderFactory;
    }

    /**
     * Save blog record action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $blog_id = $this->getRequest()->getParam('banner_id');
            if ($blog_id) {
                $this->uiExamplemodel->load($blog_id);
            }
            $model = $this->postFactory->create();
            $model->setData($data);
            $model = $this->imageData($model, $data);
            try {
                $model->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
                $this->adminsession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath('*/post/edit', ['banner_id' => $this->uiExamplemodel->getBannerId(), '_current' => true]);
                    }
                }
                return $resultRedirect->setPath('*/post/index');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/post/edit', ['banner_id' => $this->getRequest()->getParam('banner_id')]);
        }
        return $resultRedirect->setPath('*/post/index');
    }

    public function imageData($model, $data)
    {
        if (isset($data['img']) || isset($data['ffl'])) {
            if ($model->getId()) {
                $pageData = $this->postFactory->create();
                $pageData->load($model->getId());
                if (isset($data['img'][0]['name'])) {
                    $imageName1 = $pageData->getThumbnail();
                    $imageName2 = $data['img'][0]['name'];
                    if ($imageName1 != $imageName2) {
                        $imageUrl = $data['img'][0]['url'];
                        $imageName = $data['img'][0]['name'];
                        $data['img'] = $this->imageUploaderModel->saveMediaImage($imageName, $imageUrl);
                    } else {
                        $data['img'] = $data['img'][0]['name'];
                    }
                } else {
                    $data['img'] = $pageData->getData('img');
                }
            } else {
                if (isset($data['img'][0]['name'])) {
                    $imageUrl = $data['img'][0]['url'];
                    $imageName = $data['img'][0]['name'];
                    $data['img'] = $this->imageUploaderModel->saveMediaImage($imageName, $imageUrl);
                }
            }
            if ($model->getId()) {
                $pageData = $this->postFactory->create();
                $pageData->load($model->getId());
                if (isset($data['ffl'][0]['name'])) {
                    $imageName1 = $pageData->getThumbnail();
                    $imageName2 = $data['ffl'][0]['name'];
                    if ($imageName1 != $imageName2) {
                        $imageUrl = $data['ffl'][0]['url'];
                        $imageName = $data['ffl'][0]['name'];
                        $data['ffl'] = $this->imageUploaderModel->saveMediaImage($imageName, $imageUrl);
                    } else {
                        $data['ffl'] = $data['ffl'][0]['name'];
                    }
                } else {
                    $data['ffl']= $pageData->getData('ffl');
                }
            } else {
                if (isset($data['ffl'][0]['name'])) {
                    $imageUrl = $data['ffl'][0]['url'];
                    $imageName = $data['ffl'][0]['name'];
                    $data['ffl'] = $this->imageUploaderModel->saveMediaImage($imageName, $imageUrl);
                }
            }
            $model->setData($data);
            return $model;
        }
    }
}
