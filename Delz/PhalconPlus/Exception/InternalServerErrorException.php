<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Exception;

/**
 * 服务器运行异常错误
 *
 * 跟客户端访问没有关系，程序本身错误的，这跟程序员代码有关，或者服务器运行错误有关的错误
 *
 * @package Delz\PhalconPlus\Exception
 */
class InternalServerErrorException extends \RuntimeException
{
    /**
     * 服务器运行异常错误，都是5开头的
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message, int $code = 0)
    {
        parent::__construct($message, 50000 + $code);
    }
}