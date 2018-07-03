<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

/**
 * 调度控制器服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Dispatcher extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'dispatcher';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $self = $this;
        $this->di->setShared(
            $this->serviceName,
            function () use ($self) {
                $dispatcher = new MvcDispatcher();
                $dispatcher->setEventsManager($self->di->get('eventsManager'));
                return $dispatcher;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '调度控制器';
    }
}