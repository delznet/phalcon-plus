<?php

namespace Delz\PhalconPlus\Hprose\Demo;

/**
 * 这是一个测试用户服务
 *
 * @package Delz\PhalconPlus\Hprose\Demo
 */
class UserManager
{
    /**
     * 用户登录，不做任何业务处理，直接返回用户名和密码
     *
     * @param string $username
     * @param string $password
     * @return array
     */
    public function login($username, $password)
    {
        return [
            'username' => $username,
            'password' => $password
        ];
    }
}