<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;

/**
 * IUserProvider调用find方法没有找到用户异常
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class UserNotFoundException extends AuthenticationException
{
    public function __construct($message = 'User not found.')
    {
        parent::__construct($message);
    }
}