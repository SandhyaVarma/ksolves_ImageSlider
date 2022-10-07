<?php
namespace Ksolves\ImageSlider\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'banner_slider_id';
	protected $_eventPrefix = 'banner_slider_collection';
	protected $_eventObject = 'banner_slider_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Ksolves\ImageSlider\Model\Banner', 'Ksolves\ImageSlider\Model\ResourceModel\Banner');
	}

}
