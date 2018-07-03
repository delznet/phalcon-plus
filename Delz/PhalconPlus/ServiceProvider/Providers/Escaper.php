<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\Escaper as PhalconEscaper;

/**
 * 上下文编码转义服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Escaper extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'escaper';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                return new PhalconEscaper();
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '上下文编码转义';
    }
}