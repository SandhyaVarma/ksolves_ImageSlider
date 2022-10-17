<?php

namespace Ksolves\ImageSlider\Test\Unit\Block;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;
use Ksolves\ImageSlider\Block\Listing;
use Ksolves\ImageSlider\Model\BannerImageFactory;

class ListingTest extends \PHPUnit\Framework\TestCase
{

    protected $objectManagerHelper;
    protected $listing;
    protected $listingFactory;
    protected $listingCollection;

    protected function setUp(): void{
        $this->listing = $this->createMock(\Ksolves\ImageSlider\Model\BannerImage::class);
        $this->listingFactory = $this->createPartialMock(\Ksolves\ImageSlider\Model\BannerImageFactory::class, ['create']);
        $this->listingFactory->expects($this->any())->method('create')->will($this->returnValue($this->listing));
        
        $this->objectManagerHelper = new ObjectManagerHelper($this);
        $this->listingCollection = $this->objectManagerHelper->getObject(
            'Ksolves\ImageSlider\Block\Listing',
            [
                '_customFactory' => $this->listingFactory
            ]
        );
    }

    public function testgetResultData()
    {   
        $listingCollection =
            $this->createMock(\Ksolves\ImageSlider\Model\ResourceModel\BannerImage\Collection::class);
        $this->listing->expects($this->once())->method('getCollection')->will($this->returnValue($listingCollection));

        $listings = $this->listingCollection->getResultData();
        $this->assertEquals($listingCollection, $listings);
        // $this->assertTrue($this->listing->getResultData() instanceof BannerImageFactory );
    }
      
}