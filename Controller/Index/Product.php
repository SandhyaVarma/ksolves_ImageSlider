<?php

namespace Ksolves\ImageSlider\Controller\Index;

class Product extends \Magento\Framework\App\Action\Action
{
    protected $productFactory;
    protected $productRepository;
    protected $stockRegistry; 
    protected $resultPageFactory;
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Catalog\Api\Data\ProductInterfaceFactory $productFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry)
    {   
        parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
        $this->stockRegistry = $stockRegistry;
    }

	public function execute()
	{

        $product = $this->productFactory->create();
        $product->setSku('SAMPLE-ITEM');
        $product->setName('Sample Item');
        $product->setTypeId(\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE);
        $product->setVisibility(4);
        $product->setPrice(1);
        $product->setAttributeSetId(4); // Default attribute set for products
        $product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);

        $product = $this->productRepository->save($product); 

        return $this->resultPageFactory->create();
    }
}









