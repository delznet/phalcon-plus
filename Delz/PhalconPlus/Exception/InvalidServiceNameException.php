<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Exception;

/**
 * 配置服务名称与ServiceProvider中getName方法获取的服务名称不一致
 *
 * @package Delz\PhalconPlus\Exception
 */
class InvalidServiceNameException extends \InvalidArgumentException
{
    /**
     * InvalidServiceNameException constructor.
     * @param string $configServiceName 在配置项中的名称
     * @param string $providerServiceName 在ServiceProvider设置的名称
     */
    public function __construct(string $configServiceName, string $providerServiceName)
    {
        parent::__construct(
            sprintf('Invalid service name. In config is %s, but in provider class is %s.', $configServiceName, $providerServiceName)
        );
    }
}