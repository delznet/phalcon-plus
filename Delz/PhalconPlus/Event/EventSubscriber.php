<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Event;

use Phalcon\DiInterface;

/**
 * 事件订阅器抽象类
 *
 * @package Delz\PhalconPlus\Event
 */
abstract class EventSubscriber implements IEventSubscriber
{
    /**
     * @var DiInterface
     */
    protected $di;

    /**
     * 事件类型
     *
     * @var string
     */
    protected $eventType;

    /**
     * @param DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        $this->di = $di;
    }

    /**
     * {@inheritdoc}
     */
    public function getDi():DiInterface
    {
        return $this->di;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventType():string
    {
        return $this->eventType;
    }


}