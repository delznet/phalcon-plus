<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Exception;

/**
 * appId为空时抛出异常
 *
 * @package Delz\PhalconPlus\Exception
 */
class AppIdNullException extends \InvalidArgumentException
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct("appId can't be null.");
    }
}