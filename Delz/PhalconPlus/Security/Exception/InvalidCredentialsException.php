<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;

/**
 * 非法的凭证信息
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class InvalidCredentialsException extends \InvalidArgumentException
{
    public function __construct($message = 'Invalid credentials.')
    {
        parent::__construct($message);
    }
}