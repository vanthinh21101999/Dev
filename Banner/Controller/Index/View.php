<?php
namespace Dev\Banner\Controller\Index;

use Magento\Framework\App\Action\Action;
use Dev\Banner\Model\PostRepository;
use Magento\Framework\App\RequestInterface;
class View extends Action
{
    protected $bannerRepository;
    protected $request;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        RequestInterface $request,
        PostRepository $bannerRepository)
    {
        $this->request = $request;
        $this->bannerRepository = $bannerRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->request->getParams(); // all params
        $param = $this->request->getParam('id');
        $test = $this->bannerRepository->getById($param);
        echo 'get id parameter: '. $test->getId();
    }
}
