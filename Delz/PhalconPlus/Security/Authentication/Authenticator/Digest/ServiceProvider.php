<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication\Authenticator\Digest;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\Security\Authentication\Authenticator\Digest\Authenticator as DigestAuthenticator;

/**
 * 摘要认证服务提供者
 *
 * @package Delz\PhalconPlus\Security\Authentication\Authenticator\Digest
 */
class ServiceProvider extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'digestAuthenticator';

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
                $userProviderName = $config->get('security.digest.userProvider');
                if (!$userProviderName) {
                    throw new \RuntimeException('parameter: "security.digest.userProvider" is not set.');
                }
                //此处如果无法获取，会有异常
                $userProvider = $self->di->get($userProviderName);
                $tokenStorageName = $config->get('security.tokenStorage');
                if (!$tokenStorageName) {
                    $tokenStorageName = 'securityTokenStorage';
                }
                $tokenStorage = $self->di->get($tokenStorageName);
                $prefix = $config->get('security.digest.prefix');
                $request = $self->di->getShared('request');
                $eventsManager = $self->di->getShared('eventsManager');

                $authenticator = new DigestAuthenticator(
                    $request,
                    $prefix,
                    $userProvider,
                    $tokenStorage,
                    $eventsManager
                );

                $lifetime = $config->get('security.digest.lifetime');

                if($lifetime) {
                    $authenticator->setLifeTime((int)$lifetime);
                }

                return $authenticator;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '摘要认证器';
    }
}