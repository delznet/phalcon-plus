<?php

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Forms\Manager;

/**
 * 表单管理器服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class FormManager extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'forms';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                return new Manager();
            }
        );
    }
}