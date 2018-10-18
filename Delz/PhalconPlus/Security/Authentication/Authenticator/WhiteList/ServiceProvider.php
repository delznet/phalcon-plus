<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList;

use Delz\PhalconPlus\Security\Authentication\ITokenStorage;
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
                $providerName = $config->get('security.whiteList.provider');
                if (!$providerName) {
                    throw new \RuntimeException('parameter: "security.whiteList.provider" is not set.');
                }
                /** @var IWhiteListProvider $provider */
                $provider = $self->di->get($providerName);
                if (!$provider instanceof IWhiteListProvider) {
                    throw new \RuntimeException(
                        sprintf('%s must be an instance of Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList\IWhiteListProvider', get_class($provider))
                    );
                }
                $tokenStorageName = $config->get('security.tokenStorage');
                if (!$tokenStorageName) {
                    $tokenStorageName = 'securityTokenStorage';
                }
                /** @var ITokenStorage $tokenStorage */
                $tokenStorage = $self->di->get($tokenStorageName);
                if (!$tokenStorage instanceof ITokenStorage) {
                    throw new \RuntimeException(
                        sprintf('%s must be an instance of Delz\PhalconPlus\Security\Authentication\ITokenStorage', get_class($tokenStorage))
                    );
                }
                $manager = new Manager($provider->getList($tokenStorage->getToken()));
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