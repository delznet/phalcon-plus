<?php

namespace Delz\PhalconPlus\Hprose\Demo;

use Delz\PhalconPlus\ServiceProvider\Provider as ServiceProvider;

/**
 * 用户服务提供者
 * @package Delz\PhalconPlus\Hprose\Demo
 */
class UserManagerProvider extends ServiceProvider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'user-manager';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                return new UserManager();
            }
        );
    }
}