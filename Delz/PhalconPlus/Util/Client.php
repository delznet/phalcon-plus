<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Util;

/**
 * 客户端工具
 *
 * @package Delz\PhalconPlus\Util
 */
class Client
{
    /**
     * 获取客户端ip
     *
     * @return string
     */
    static function ip():?string
    {
        static $ip = NULL;
        if ($ip !== NULL) {
            return $ip;
        }
        //判断服务器是否允许$_SERVER
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            //不允许就使用getenv获取  
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $ip = getenv('HTTP_CLIENT_IP');
            } else {
                $ip = getenv('REMOTE_ADDR');
            }
        }

        return $ip;
    }
}