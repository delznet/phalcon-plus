<?php

namespace Delz\PhalconPlus\Security\Exception;

use Delz\PhalconPlus\Exception\InternalServerErrorException;

/**
 *
 * 认证器没有配置异常
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class AuthenticatorNotSetException extends InternalServerErrorException implements IAuthenticationException
{
    public function __construct($message = 'Authenticator is not set.', $code = Exceptions::AUTHENTICATOR_NOT_SET)
    {
        parent::__construct($message, $code);
    }

}