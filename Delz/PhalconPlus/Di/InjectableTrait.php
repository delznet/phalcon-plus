<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Di;

use Delz\PhalconPlus\IoC;

/**
 * 继承Phalcon\Di\Injectable实现了魔术方法__get,
 * 但是PhalconPlus重写了Di的get方法后，实现逻辑不一样，
 * 所有原生的继承Phalcon\Di\Injectable的__get需要用这个trait类重写一下。
 *
 * @package Delz\PhalconPlus\Di
 */
trait InjectableTrait
{
    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if ($name == 'di') {
            return IoC::getDi();
        }

        try {
            return IoC::get($name);
        } catch (\Exception $e) {
            return null;
        }
    }
}