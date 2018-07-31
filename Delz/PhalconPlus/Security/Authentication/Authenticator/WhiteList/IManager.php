<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList;

/**
 * 白名单管理服务接口类
 *
 * @package Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList
 */
interface IManager
{
    /**
     * 检查$ip是否在白名单内
     *
     * @param string $ip
     * @return bool
     */
    public function check(string $ip):bool;
}