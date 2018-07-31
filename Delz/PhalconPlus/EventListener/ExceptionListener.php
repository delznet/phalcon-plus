<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\EventListener;

use Delz\PhalconPlus\Event\EventListener;
use Phalcon\Events\Event;

/**
 * 监听Delz\PhalconPlus\Event::APPLICATION_EXCEPTION事件
 *
 * @package Delz\PhalconPlus\EventListener
 */
class ExceptionListener extends EventListener
{
    /**
     * @param Event $event
     * @param \Exception $e
     * @param string $module
     * @throws $e
     */
    public function onException(Event $event, \Exception $e, string $module = '')
    {
        throw $e;
    }
}