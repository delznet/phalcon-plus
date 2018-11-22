<?php

namespace Delz\PhalconPlus\Security\Exception;

/**
 *
 * 认证器没有配置异常
 *
 * 控制器方法必须配置相应的验证器，如果没有配置，就会出现抛出此异常
 *
 * 出现这个异常是程序设计问题，所以异常不应继承AuthenticationException
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class AuthenticatorNotSetException extends \RuntimeException
{
    public function __construct($message = 'Authenticator is not set.', $code = Exceptions::AUTHENTICATOR_NOT_SET)
    {
        parent::__construct($message, $code);
    }

}