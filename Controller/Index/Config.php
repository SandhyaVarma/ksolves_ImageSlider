<?php

namespace Ksolves\ImageSlider\Controller\Index;

class Config extends \Magento\Framework\App\Action\Action
{
    protected $_productFactory;
    protected $_resourceModel;
    protected $sourceItemsSaveInterface;
    protected $sourceItem;
    protected $attributeRepository;
    protected $_optionsFactory;
    protected $productRepository;
    protected $categorySetup;

    public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \Magento\Catalog\Model\ProductFactory $productFactory,
    \Magento\Catalog\Model\ResourceModel\Product $resourceModel,
    \Magento\InventoryApi\Api\Data\SourceItemInterface $sourceItemsSaveInterface,
    \Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory $sourceItem,
    \Magento\Eav\Api\AttributeRepositoryInterface $attributeRepository,
    \Magento\ConfigurableProduct\Helper\Product\Options\Factory $optionsFactory,
    \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
    \Magento\Catalog\Setup\CategorySetup $categorySetup) 
    {
        parent::__construct($context);
        $this->_productFactory = $productFactory;
        $this->_resourceModel = $resourceModel;
        $this->sourceItemsSaveInterface = $sourceItemsSaveInterface;
        $this->sourceItem = $sourceItem;
        $this->attributeRepository = $attributeRepository;
        $this->_optionsFactory = $optionsFactory;
        $this->productRepository = $productRepository;
        $this->categorySetup = $categorySetup;
   }

public function execute()
{
   $product = $this->_productFactory->create();
   $colorAttr = $this->attributeRepository->get(\Magento\Catalog\Model\Product::ENTITY, 'color');
   $associatedProductIds = [];
   $options = $colorAttr->getOptions();
   $values = [];
   $sourceItems = [];
   array_shift($options);
   try {
       //Create Simple product
       foreach ($options as $index => $option) {
           $product->unsetData();
           $product->setTypeId(\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE)
                    ->setAttributeSetId(4)
                    ->setWebsiteIds([1])
                    ->setName('Sample_shirt-' . $option->getLabel())
                    ->setSku('shirt' . $index)
                    ->setPrice(10)
                    ->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_NOT_VISIBLE)
                    ->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
           $product->setCustomAttribute(
               $colorAttr->getAttributeCode(),
               $option->getValue()
           );
           $this->_resourceModel->save($product);

           // Update Stock Data
           $sourceItem = $this->sourceItem->create();
           $sourceItem->setSourceCode(null);
           $sourceItem->setSourceCode('default');
           $sourceItem->setQuantity(10);
           $sourceItem->setSku($product->getSku());
           $sourceItems[] = $sourceItem;

           $values[] = [
               "value_index" => $option->getValue(),
           ];

           $associatedProductIds[] = $product->getId();
       }


        //Create Configurable Product
        $configurable = $product->unsetData();
        $configurable->setSku('sample_configurable');
        $configurable->setName('Sample Configurable');
        $configurable->setTypeId('configurable');
        $configurable->setPrice(10);
        $configurable->setAttributeSetId($this->categorySetup->getAttributeSetId(\Magento\Catalog\Model\Product::ENTITY, 'Default'));
        
        //Assign simple products to the configurable product
        $extensionAttrs = $configurable->getExtensionAttributes();
        $extensionAttrs->setConfigurableProductLinks($associatedProductIds);
        $optionsFact = $this->_optionsFactory->create([
        [
            "attribute_id" => $colorAttr->getId(),
            "label" => $colorAttr->getDefaultFrontendLabel(),
            "position" => 0,
            "values" => $values,
        ]
        ]);
        $extensionAttrs->setConfigurableProductOptions($optionsFact);
        $configurable->setExtensionAttributes($extensionAttrs);

        $this->productRepository->save($configurable);
    }
    catch(\Exception $e){
        echo "<pre>";
        print_r($e->getTrace());
        print_r($e->getMessage());
        exit();
    }

    }
}
