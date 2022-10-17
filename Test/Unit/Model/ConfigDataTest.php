<?php

namespace Ksolves\ImageSlider\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use Ksolves\ImageSlider\Model\ConfigData;
use Magento\Store\Model\ScopeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Magento\Framework\App\Config\ScopeConfigInterface;


class ConfigDataTest extends TestCase
{
    private $scopeConfigInterface;

    private $model;

    protected function setUp(): void
    {
        $this->scopeConfigInterface = $this->createMock(ScopeConfigInterface::class);

        $this->model = new ConfigData(
            $this->scopeConfigInterface
        );
    }

    public function testIsModuleEnable(): void
    {
        $this->scopeConfigInterface->expects($this->once())->method('getValue')
            ->with(ConfigData::XML_PATH_CHECK_MODULE_ENABLE, ScopeInterface::SCOPE_STORE)
            ->will($this->returnValue(true));
        $this->assertTrue((bool)$this->model->isModuleEnable());
    }
}
