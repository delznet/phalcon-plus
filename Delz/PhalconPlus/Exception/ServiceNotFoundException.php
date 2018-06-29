<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Exception;

/**
 * 服务没有找到异常
 *
 * @package Delz\PhalconPlus\Exception
 */
class ServiceNotFoundException extends \InvalidArgumentException
{
    /**
     * ServiceNotFoundException constructor.
     * @param string $serviceName 服务名称
     */
    public function __construct(string $serviceName)
    {
        parent::__construct(
            sprintf('Service with name %s not found.', $serviceName)
        );
    }
}