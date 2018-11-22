<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication;

use Delz\PhalconPlus\Event\IEventListener;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

/**
 * 认证拦截器
 *
 * 通过监听dispatch:beforeDispatch事件实现
 *
 * @package Delz\PhalconPlus\Security\Authentication
 */
interface IAuthenticationListener extends IEventListener
{
    /**
     * 实现dispatch:beforeDispatch事件
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher);
}