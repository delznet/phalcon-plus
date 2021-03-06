<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Exception;


/**
 * 客户端非法请求异常
 *
 * @package Delz\PhalconPlus\Exception
 */
class BadRequestException extends \RuntimeException
{
    /**
     * 客户端非法请求错误，都是4开头的
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message, int $code = 0)
    {
        parent::__construct($message, 40000 + $code);
    }
}