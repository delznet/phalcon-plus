<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Exception;

/**
 * 服务提供者类不存在
 *
 * @package Delz\PhalconPlus\Exception
 */
class ServiceProviderClassNotFoundException extends \InvalidArgumentException
{
    /**
     * ServiceProviderClassNotFoundException constructor.
     * @param string $serviceProviderClass 服务提供者类
     */
    public function __construct(string $serviceProviderClass)
    {
        parent::__construct(
            sprintf('class %s not found.', $serviceProviderClass)
        );
    }
}