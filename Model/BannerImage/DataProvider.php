<?php
namespace Ksolves\ImageSlider\Model\BannerImage;
 
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $bannerImageCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Ksolves\ImageSlider\Model\ResourceModel\BannerImage\CollectionFactory $bannerImageCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $bannerImageCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
 
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return [];
    }

}
