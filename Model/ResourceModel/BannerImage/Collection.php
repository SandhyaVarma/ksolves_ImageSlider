<?php
namespace Ksolves\ImageSlider\Model\ResourceModel\BannerImage;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'banner_slider_image_id';
	protected $_eventPrefix = 'banner_slider_image_collection';
	protected $_eventObject = 'banner_slider_image_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Ksolves\ImageSlider\Model\BannerImage', 'Ksolves\ImageSlider\Model\ResourceModel\BannerImage');
	}

}
