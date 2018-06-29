<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Mvc\View\Engine;

use Delz\PhalconPlus\Di\InjectableTrait;

/**
 * php模板
 *
 * @package Delz\PhalconPlus\Mvc\View\Engine
 */
class Php extends \Phalcon\Mvc\View\Engine\Php
{
    use InjectableTrait;
}