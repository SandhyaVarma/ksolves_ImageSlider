<?php declare(strict_types=1);

namespace Ksolves\ImageSlider\Model;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigData
{
    const XML_PATH_CHECK_MODULE_ENABLE = 'banner/general/enable';

    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    
    public function isModuleEnable(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_CHECK_MODULE_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }
}