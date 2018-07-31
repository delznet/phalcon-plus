<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication;

use Delz\PhalconPlus\Security\Exception\AuthenticationException;

/**
 * 认证器接口
 *
 * @package Delz\PhalconPlus\Security\Authentication
 */
interface IAuthenticator
{
    /**
     * 处理认证
     *
     * 如果认证成功，返回true
     * 如果认证失败，抛出AuthenticationException异常
     *
     * @return bool
     * @throws AuthenticationException
     */
    public function handle();

}