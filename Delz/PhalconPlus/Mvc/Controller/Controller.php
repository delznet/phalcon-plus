<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Mvc\Controller;
use Delz\PhalconPlus\Di\InjectableTrait;

/**
 * 基础控制器
 *
 * @package Delz\PhalconPlus\Mvc\Controller
 */
class Controller extends \Phalcon\Mvc\Controller
{
    use InjectableTrait;

    /**
     * 根据服务名称获取服务
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        return $this->getDI()->get($name);
    }
}