<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;

/**
 * 认证器服务没有找到
 *
 * 是开发配置问题，所以不用继承AuthenticationException
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class AuthenticatorsNotFoundException extends \RuntimeException
{
    public function __construct($message = 'Authenticator is not set.', $code = Exceptions::AUTHENTICATORS_NOT_FOUND)
    {
        parent::__construct($message, $code);
    }

}