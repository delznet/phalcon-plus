<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Config\IConfig;
use Phalcon\Mvc\Model\Manager as PhalconModelManager;

/**
 * 模型管理器服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class ModelsManager extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'modelsManager';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $self = $this;
        $this->di->setShared(
            $this->serviceName,
            function () use ($self) {
                $modelManager = new PhalconModelManager();
                /** @var IConfig $config */
                $config = $self->di->getShared('config');
                $prefix = $config->get('model.prefix', '');
                $modelManager->setModelPrefix($prefix);
                $modelManager->setEventsManager($self->di->get('eventsManager'));
                $modelManager->setDI($self->di);

                return $modelManager;

            }
        );
    }

}