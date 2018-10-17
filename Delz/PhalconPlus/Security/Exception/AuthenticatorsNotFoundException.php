<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;

use Delz\PhalconPlus\Exception\InternalServerErrorException;

/**
 * 认证器没有找到
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class AuthenticatorsNotFoundException extends InternalServerErrorException implements IAuthenticationException
{
    public function __construct($message = 'Authenticator is not set.', $code = Exceptions::AUTHENTICATORS_NOT_FOUND)
    {
        parent::__construct($message, $code);
    }

}