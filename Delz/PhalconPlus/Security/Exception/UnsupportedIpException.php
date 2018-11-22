<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;

/**
 * ip白名单验证的时候不在名单内异常
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class UnsupportedIpException extends AuthenticationException
{
    public function __construct($message = 'Unsupported Ip', $code = Exceptions::UNSUPPORTED_IP)
    {
        parent::__construct($message, $code);
    }
}