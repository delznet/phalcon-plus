<?php

namespace Delz\PhalconPlus\Security\Exception;
use Delz\PhalconPlus\Exception\BadRequestException;

/**
 * token无法创建
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class TokenNotCreatedException extends AuthenticationException
{
    public function __construct($message = 'Token not created.', $code = Exceptions::TOKEN_NOT_CREATED)
    {
        parent::__construct($message, $code);
    }
}