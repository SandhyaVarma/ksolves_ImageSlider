<?php
namespace Ksolves\ImageSlider\Model\ResourceModel;


class BannerImage extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	
	protected function _construct()
	{
		$this->_init('banner_slider_image', 'banner_image_id');

	}
	
}
