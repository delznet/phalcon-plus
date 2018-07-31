<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;

/**
 * 鉴权异常
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class AuthenticationException extends \RuntimeException
{
    public function __construct($message = 'An authentication exception occurred.')
    {
        parent::__construct($message);
    }

}