<?php
namespace Ksolves\ImageSlider\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Listing extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
		return parent::__construct($context);
	}

	public function execute()
	{	
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Banner Image'));
        return $resultPage;
	
	}
}