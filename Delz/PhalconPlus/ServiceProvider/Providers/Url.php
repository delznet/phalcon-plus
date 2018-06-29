<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Mvc\Url as BaseUrl;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\App\IApp;

/**
 * 网址服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Url extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'url';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $self = $this;
        $this->di->setShared(
            $this->serviceName,
            function () use ($self) {
                /** @var IApp $app */
                $app = $self->di->getShared('app');
                /** @var IConfig $config */
                $config = $self->di->getShared('config');
                $url = new BaseUrl();
                $url->setBaseUri($config->get('url.' . $app->getModule() . '.base_path', ''));
                $url->setStaticVersion($config->get('url.' . $app->getModule() . '.static.version', $app->getVersion()));
                $url->setStaticBaseUri($config->get('url.' . $app->getModule() . '.static.base_uri', ''));
                return $url;
            }
        );
    }
}