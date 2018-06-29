<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Event;

use Phalcon\DiInterface;

/**
 * 事件监听接口
 *
 * @package Delz\PhalconPlus\Event
 */
interface IEventListener
{
    /**
     * @return DiInterface
     */
    public function getDi():DiInterface;
}