<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;

/**
 * 用户没有激活异常
 *
 * IUser对象的isEnabled为false的时候
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class DisableException extends AuthenticationException
{
    public function __construct($message = 'User is disabled', $code = Exceptions::USER_DISABLE)
    {
        parent::__construct($message, $code);
    }
}