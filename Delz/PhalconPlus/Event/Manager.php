<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Event;

use Phalcon\DiInterface;
use Delz\PhalconPlus\Config\IConfig;

/**
 * 事件管理器
 *
 * @package Delz\PhalconPlus\Event
 */
class Manager extends \Phalcon\Events\Manager
{
    /**
     * @var DiInterface
     */
    protected $di;

    /**
     * 已经实例化的事件监听类
     *
     * @var array
     */
    protected $resolvedListener = [];

    /**
     * 已经实例化的事件订阅类
     *
     * @var array
     */
    protected $resolvedSubscriber = [];

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
     * 重写事件执行，增加事件懒加载逻辑
     *
     * @param string $eventType
     * @param object $source
     * @param null $data
     * @param bool $cancelable
     * @return mixed
     */
    public function fire($eventType, $source, $data = null, $cancelable = true)
    {
        $eventParts = explode(':', $eventType);
        if (count($eventParts) == 2) {
            $type = $eventParts[0];
            //$eventName = $eventParts[1];
            /** @var IConfig $config */
            $config = $this->di->get('config');
            $subscriberClass = $config->get('events.' . $type);
            if ($subscriberClass) {
                $subscriber = null;
                if (!isset($this->resolvedSubscriber[$subscriberClass])) {
                    /** @var IEventSubscriber $subscriber */
                    $subscriber = new $subscriberClass($this->di);
                    if ($subscriber->getEventType() !== $type) {
                        throw new \InvalidArgumentException(
                            sprintf('Invalid event type, expect %s, %s given.', $type, $subscriber->getEventType())
                        );
                    }
                    $this->resolvedSubscriber[$subscriberClass] = $subscriber;
                } else {
                    $subscriber = $this->resolvedSubscriber[$subscriberClass];
                }
                $events = $subscriber->getEvents();
                if (isset($events[$eventType])) {
                    foreach ($events[$eventType] as $listener) {
                        $listenerClass = $listener[0];
                        $priority = isset($listener[1]) ? (int)$listener[1] : 0;
                        if (isset($this->resolvedListener[$listenerClass])) {
                            //不用处理
                        } else {
                            $listener = new $listenerClass($this->di);
                            if (!($listener instanceof IEventListener)) {
                                throw new \InvalidArgumentException(
                                    sprintf('class %s not instance of Delz\PhalconPlus\Event\IEventListener', $listenerClass)
                                );
                            }
                            $this->resolvedListener[$listenerClass] = $listener;
                            $this->attach($type, $listener, $priority);
                        }

                    }
                }
            }
        }
        return parent::fire($eventType, $source, $data, $cancelable);
    }

}