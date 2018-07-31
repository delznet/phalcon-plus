<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;

/**
 * 用户鉴权失败异常
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class BadCredentialsException extends AuthenticationException
{
    public function __construct($message = 'Bad credentials.')
    {
        parent::__construct($message);
    }
}