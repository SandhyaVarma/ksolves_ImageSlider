<?php
namespace Ksolves\ImageSlider\Model\Banner;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Ksolves\ImageSlider\Model\ResourceModel\Banner\CollectionFactory;
 
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{   
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    
    /**
     * @var array
     */
    protected $loadedData;
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $bannerCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bannerCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $bannerCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->meta = $this->prepareMeta($this->meta);
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
 
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    public function getData()
    {   
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getBannerId()] = $model->getData();
        }
        return $this->loadedData;

    }
}
