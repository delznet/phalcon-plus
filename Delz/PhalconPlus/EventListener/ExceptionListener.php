<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\EventListener;

use Delz\PhalconPlus\Event\EventListener;
use Phalcon\Events\Event;
use Phalcon\Http\Response;

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
     */
    public function onException(Event $event, \Exception $e)
    {
        $content = sprintf('Error:[%d] %s', $e->getCode(), $e->getMessage());
        $response = new Response();
        $response->setContent($content);
        $response->send();
    }
}