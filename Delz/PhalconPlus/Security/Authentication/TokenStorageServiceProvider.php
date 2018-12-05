<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Security\Authentication;

use Delz\PhalconPlus\ServiceProvider\Provider;

/**
 * token存储器服务提供者
 *
 * @package Delz\PhalconPlus\Security\Authentication
 */
class TokenStorageServiceProvider extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    //protected $serviceName = 'securityTokenStorage';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                return new TokenStorage();
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '认证token存储器';
    }
}