<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\ValidCode;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Config\IConfig;
use Phalcon\Cache\BackendInterface as ICache;

/**
 * 验证码服务提供者
 *
 * @package Delz\PhalconPlus\ValidCode
 */
class ServiceProvider extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'validCode';

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
                //获取验证码缓存服务名称
                $cacheServiceName = $config->get('validCode.cache');
                /** @var  ICache $cache */
                $cache = $this->di->get($cacheServiceName);
                return new Manager($cache);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '验证码服务';
    }
}