<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\Assets\Manager;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\App\IApp;

/**
 * 资源文件管理服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class AssetsManager extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'assets';

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
                return new Manager([
                    'sourceBasePath' => $app->getRootDir() . $config->get('assets.source_base_path', DIRECTORY_SEPARATOR . 'resources/assets' . DIRECTORY_SEPARATOR),
                    'targetBasePath' => $app->getRootDir() . $config->get('assets.target_base_path', '/public'),
                    'configFilePath' => $app->getRootDir() . $config->get('assets.config_file_path', '/resources/config/assets.yml')
                ]);
            }
        );
    }

}