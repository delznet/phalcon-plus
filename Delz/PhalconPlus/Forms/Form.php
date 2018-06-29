<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Forms;

use Delz\PhalconPlus\Di\InjectableTrait;

/**
 * 表单
 *
 * 修改了父类__get方法
 *
 * @package Delz\PhalconPlus\Forms
 */
class Form extends \Phalcon\Forms\Form
{
    use InjectableTrait;
}