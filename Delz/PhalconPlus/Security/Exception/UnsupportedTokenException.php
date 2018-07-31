<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;
use Delz\PhalconPlus\Exception\InternalServerErrorException;

/**
 * token对象异常
 *
 * 调用checkCredentials($token,$user),有的时候要验证$token的类型，
 * 如果是不是预期的$token对象，抛出此异常。
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class UnsupportedTokenException extends InternalServerErrorException implements IAuthenticationException
{
    public function __construct($message = 'Unsupported Token', $code = Exceptions::UNSUPPORTED_TOKEN)
    {
        parent::__construct($message, $code);
    }
}