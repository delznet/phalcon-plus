<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Event;

use Phalcon\DiInterface;

/**
 * 事件监听
 *
 * @package Delz\PhalconPlus\Event
 */
class EventListener implements IEventListener
{
    /**
     * @var DiInterface
     */
    protected $di;

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

}