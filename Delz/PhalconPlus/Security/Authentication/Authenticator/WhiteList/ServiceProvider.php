<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Config\IConfig;

/**
 * 白名单认证服务提供者
 *
 * @package Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList
 */
class ServiceProvider extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'whiteListAuthenticator';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $self = $this;
        $this->di->setShared(
            $this->serviceName,
            function () use ($self) {
                /** @var IConfig $config */
                $config = $self->di->getShared('config');
                $managerName = $config->get('security.whiteList.manager');
                if (!$managerName) {
                    throw new \RuntimeException('parameter: "security.whiteList.manager" is not set.');
                }
                $manager = $self->di->get($managerName);
                return new Authenticator($manager);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '白名单认证器';
    }
}