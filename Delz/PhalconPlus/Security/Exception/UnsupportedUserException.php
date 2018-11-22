<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;

/**
 * 用户对象不符合异常
 *
 * 调用checkCredentials($token,$user),有的时候要验证$user和$token的参数，
 * 不同$user验证的属性可能不一样，所以需要不同的$user对象，如果是不是预期的$user对象，抛出此异常。
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class UnsupportedUserException extends AuthenticationException
{
    public function __construct($message = 'Unsupported User', $code = Exceptions::UNSUPPORTED_USER)
    {
        parent::__construct($message, $code);
    }
}