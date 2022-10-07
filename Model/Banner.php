<?php
namespace Ksolves\ImageSlider\Model;
 
class Banner extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'banner_slider';

	protected $_cacheTag = 'banner_slider';

	protected $_eventPrefix = 'banner_slider';

        protected function _construct()
        {
                $this->_init('Ksolves\ImageSlider\Model\ResourceModel\Banner');
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