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

    const AUTHENTICATOR_NOT_SET = 50100;
    const UNSUPPORTED_TOKEN = 50101;
    const UNSUPPORTED_USER = 50102;
    const AUTHENTICATORS_NOT_FOUND = 50103;


    /*******************************************************
     * 客户端部分
     * *****************************************************
     */
    const BAD_CREDENTIALS = 40100;
    const USER_DISABLE = 40101;
    const INVALID_CREDENTIALS = 40102;
    const UNSUPPORTED_IP = 40103;
    const USER_NOT_FOUND = 40104;
    const TOKEN_NOT_CREATED = 40105;
}