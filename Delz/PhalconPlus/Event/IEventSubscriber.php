<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Event;

use Phalcon\DiInterface;

/**
 * 将同一类型的事件类型的事件订阅通过getEvents()返回
 *
 * @package Delz\PhalconPlus\Event
 */
interface IEventSubscriber
{
    /**
     * @return DiInterface
     */
    public function getDi():DiInterface;

    /**
     * 返回事件数组
     *
     *
     * 比如事件类型是db， 格式参考：
     *
     * [
     *      'db:beforeQuery' = [
     *          ['Demo/firstEventListener', 1],
     *          ['Demo/secondEventListener', 2],
     *      ],
     *      'db:afterQuery' = [
     *          ['Demo/firstEventListener', 1],
     *          ['Demo/secondEventListener', 2],
     *      ]
     * ]
     *
     * 命令规范是
     * db:beforeQuery和db:afterQuery是事件名称
     * Demo/firstEventListener和Demo/secondEventListener是监听的类名，数字1，2表示优先级，数字越大，优先级越高
     *
     * @return array
     */
    public function getEvents():array;

    /**
     * 返回事件类型
     *
     * @return string
     */
    public function getEventType():string;
}