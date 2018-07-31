<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Exception;

use Delz\PhalconPlus\Exception\BadRequestException;

/**
 * IUserProvider调用find方法没有找到用户异常
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class UserNotFoundException extends BadRequestException implements IAuthenticationException
{
    public function __construct($message = 'User Not Found', $code = Exceptions::USER_NOT_FOUND)
    {
        parent::__construct($message, $code);
    }
}