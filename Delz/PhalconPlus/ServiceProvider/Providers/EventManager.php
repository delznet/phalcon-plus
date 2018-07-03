<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Event\Manager;

/**
 * 事件管理服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class EventManager extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'eventsManager';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $self = $this;
        $this->di->setShared(
            $this->serviceName,
            function () use ($self) {
                $eventsManager = new Manager($self->di);
                $eventsManager->enablePriorities(true);
                return $eventsManager;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '事件管理';
    }
}