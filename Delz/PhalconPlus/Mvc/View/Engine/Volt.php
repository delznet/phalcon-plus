<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Mvc\View\Engine;

use Delz\PhalconPlus\Di\InjectableTrait;

/**
 * volt模板
 *
 * @package Delz\PhalconPlus\Mvc\View\Engine
 */
class Volt extends \Phalcon\Mvc\View\Engine\Volt
{
    use InjectableTrait;
}