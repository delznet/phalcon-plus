<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;

use Delz\PhalconPlus\Exception\BadRequestException;

/**
 * 非法的凭证信息
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class InvalidCredentialsException extends BadRequestException implements IAuthenticationException
{
    public function __construct($message = 'Invalid credentials.', $code = Exceptions::INVALID_CREDENTIALS)
    {
        parent::__construct($message, $code);
    }
}