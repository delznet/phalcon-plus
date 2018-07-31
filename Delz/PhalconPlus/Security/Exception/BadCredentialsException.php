<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;

use Delz\PhalconPlus\Exception\BadRequestException;

/**
 * 用户鉴权失败异常
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class BadCredentialsException extends BadRequestException implements IAuthenticationException
{
    public function __construct($message = 'Bad credentials.', $code = Exceptions::BAD_CREDENTIALS)
    {
        parent::__construct($message, $code);
    }
}