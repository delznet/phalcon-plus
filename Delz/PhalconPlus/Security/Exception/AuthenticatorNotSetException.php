<?php

namespace Delz\PhalconPlus\Security\Exception;

use Exception;

/**
 *
 * 认证器没有配置异常
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class AuthenticatorNotSetException extends AuthenticationException
{
    public function __construct($message = 'Authenticator is not set.')
    {
        parent::__construct($message);
    }

}