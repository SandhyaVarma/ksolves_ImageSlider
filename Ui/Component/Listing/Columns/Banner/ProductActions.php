<?php
namespace Ksolves\ImageSlider\Ui\Component\Listing\Columns\Banner;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class ProductActions extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /** Url Path */
    const PRODUCT_URL_PATH_EDIT = 'imageslider/banner/form';

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = array(),
        array $data = array()) 
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return void
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');                
                if (isset($item['banner_id'])) {                    
                    $item[$name] = html_entity_decode('<a href="'.$this->urlBuilder->getUrl(self::PRODUCT_URL_PATH_EDIT, ['id' => $item['banner_id']]).'">'.'Edit'.'</a>');
                }
            }
        }
        return $dataSource;
    }
}
