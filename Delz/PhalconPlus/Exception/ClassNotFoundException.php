<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Exception;

/**
 * 类没有找到异常
 *
 * @package Delz\PhalconPlus\Exception
 */
class ClassNotFoundException extends \RuntimeException
{
    /**
     * @param string $class 类名
     */
    public function __construct(string $class)
    {
        parent::__construct(
            sprintf('class %s not found', $class)
        );
    }
}