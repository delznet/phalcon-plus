<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\Mvc\Model\MetaData\Apc as ApcMetaData;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\App\IApp;

/**
 * 模型元数据服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class ModelsMetaData extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'modelsMetadata';

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

                $lifetime = (int)$config->get('model.metadata.lifetime', 86400);
                $prefix = $app->getAppId() . '_metadata';

                $metadata = new ApcMetaData([
                    "lifetime" => $lifetime,
                    'prefix' => $prefix
                ]);
                return $metadata;
            }
        );
    }
}