<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\User;

/**
 * 用户
 *
 * @package Delz\PhalconPlus\Security\User
 */
interface IUser
{
    /**
     * 获取用户的角色数组
     *
     * @return array
     */
    public function getRoles():array;

    /**
     * 用户是否激活状态
     *
     * @return bool
     */
    public function isEnabled():bool;
}