<?php 

namespace Ksolves\ImageSlider\Controller\Index;

class Import extends \Magento\Framework\App\Action\Action
{
    protected $productFactory;
    protected $productRepository;
    protected $driverFile;
    protected $resultPageFactory;

    public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \Magento\Framework\View\Result\PageFactory $resultPageFactory,
    \Magento\Catalog\Api\Data\ProductInterfaceFactory $productFactory,
    \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
    \Magento\Framework\Filesystem\Driver\File $driverFile)

    {
    parent::__construct($context);
    $this->resultPageFactory = $resultPageFactory;
    $this->productFactory = $productFactory;
    $this->productRepository = $productRepository;
    $this->driverFile = $driverFile;
    }

  public function execute()
  {
    $file = $this->driverFile->fileOpen('var/import/product.csv', 'r');
    if($file!== false)
    {
        $header = $this->driverFile->fileGetCsv($file);
        $required_data_fields = 3;

        while ($row = $this->driverFile->fileGetCsv($file, 3000, ","))
        {
            $data_count = count($row);
            if ($data_count < 1)
            {
                continue;
            }
        $product = $this->productFactory->create();
        $data = array();
        $data = array_combine($header, $row);

        $sku = $data['sku'];
        if ($data_count < $required_data_fields)
        {
            $logger->info("Skipping product sku " . $sku . ", not all required fields are present to create the product.");
            continue;
        }

        $name = $data['name'];
        $description = $data['description'];
        $shortDescription = $data['short_description'];
        $qty = trim($data['qty']);
        $price = trim($data['price']);

        $writer = new \Zend_Log_Writer_Stream(BP .  '/var/log/import-product.log'); //custom log file
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info($data['name'],true);

        try
        {
            $product->setTypeId(\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE); // product type
            $product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED); // 1 = enabled
            $product->setAttributeSetId(4);
            $product->setName($name);
            $product->setSku($sku);
            $product->setPrice($price);
            $product->setQty($qty);
            $product->setTaxClassId(0); // 0 = None
            $product->setCategoryIds(array(2, 3)); // array of category IDs, 2 = Default Category
            $product->setDescription($description);
            $product->setShortDescription($shortDescription);
            $product->setWebsiteIds(array(1)); // Default Website ID
            $product->setStoreId(0); // Default store ID
            $product->setVisibility(4); // 4 = Catalog & Search
            $product = $this->productRepository->save($product);
            
        }
        catch (\Exception $e)
        {
            $logger->info('Error importing product sku: '.$sku.'. '.$e->getMessage());
            continue;
        }
        
    }
        $this->driverFile->fileClose($file);
    
    }   
    return $this->resultPageFactory->create();
  }
}

