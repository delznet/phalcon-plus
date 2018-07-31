<?php

namespace Delz\PhalconPlus\Security\Exception;

/**
 * token无法创建
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class TokenNotCreatedException extends AuthenticationException
{
    public function __construct($message = 'Token not created.')
    {
        parent::__construct($message);
    }
}