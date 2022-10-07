<?php
namespace Ksolves\ImageSlider\Model;
 
class BannerImage extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'banner_slider_image';

	protected $_cacheTag = 'banner_slider_image';

	protected $_eventPrefix = 'banner_slider_image';

        protected function _construct()
        {
                $this->_init('Ksolves\ImageSlider\Model\ResourceModel\BannerImage');
        }
 
        public function getIdentities()
        {
                return [self::CACHE_TAG . '_' . $this->getId()];
        }
 
        public function getDefaultValues()
        {
                $values = [];
 
                return $values;
        }
}