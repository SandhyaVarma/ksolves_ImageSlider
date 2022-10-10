<?php

namespace Ksolves\ImageSlider\Block;

use Magento\Framework\View\Element\Template;

class Listing extends Template
{
    protected $_customFactory;
    protected $_customdataCollection;
 
    public function __construct(
        Template\Context $context,
        \Ksolves\ImageSlider\Model\BannerImageFactory $customFactory,
        \Ksolves\ImageSlider\Model\ResourceModel\BannerImage\CollectionFactory $customdataCollection,  
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_customFactory = $customFactory;
        $this->_customdataCollection = $customdataCollection;

    }

     public function getResultData()
     {
          $custom = $this->_customFactory->create();
          $collection = $custom->getCollection();
          return $collection;
     }
 }