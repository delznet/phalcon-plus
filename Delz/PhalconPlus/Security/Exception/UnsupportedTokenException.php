<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;

/**
 * token对象异常
 *
 * 调用checkCredentials($token,$user),有的时候要验证$token的类型，
 * 如果是不是预期的$token对象，抛出此异常。
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class UnsupportedTokenException extends AuthenticationException
{
    public function __construct($message = 'Unsupported Token.')
    {
        parent::__construct($message);
    }
}