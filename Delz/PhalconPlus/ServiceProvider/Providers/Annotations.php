<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\Annotations\Adapter\Apc as ApcAnnotations;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\App\IApp;

/**
 * 注释解析器服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Annotations extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'annotations';

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
                /** @var IApp $app */
                $app = $self->di->getShared('app');
                $prefix = $app->getAppId() . '_' . $app->getModule();
                $lifetime = $config->get('annotations.apc.lifetime', 3600);
                return new ApcAnnotations([
                    'prefix' => $prefix,
                    'lifetime' => $lifetime
                ]);
            }
        );
    }
}