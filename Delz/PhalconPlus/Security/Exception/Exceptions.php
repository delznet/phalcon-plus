<?php

namespace Delz\PhalconPlus\Security\Exception;

/**
 * 认证异常表
 *
 * @package Delz\PhalconPlus\Security\Exception
 */
class Exceptions
{
    /*******************************************************
     * 服务端部分
     * *****************************************************
     */

    const AUTHENTICATOR_NOT_SET = 100;
    const UNSUPPORTED_TOKEN = 101;
    const UNSUPPORTED_USER = 102;


    /*******************************************************
     * 客户端部分
     * *****************************************************
     */
    const BAD_CREDENTIALS = 100;
    const USER_DISABLE = 101;
    const INVALID_CREDENTIALS = 102;
    const UNSUPPORTED_IP = 103;
    const USER_NOT_FOUND = 104;
    const TOKEN_NOT_CREATED = 105;
}