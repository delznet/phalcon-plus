<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Security\User;

/**
 * 用户
 *
 * @package Delz\PhalconPlus\Security\User
 */
interface IUser extends ICredentialsHolder
{
    /**
     * 获取用户的角色数组
     *
     * @return array
     */
    public function getRoles(): array;

    /**
     * 用户是否启用
     *
     * 一般针对用户第一次开启的时候过的过滤
     *
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * 用户被激活后，因某种原因账户被锁定
     *
     * @return bool
     */
    public function isLocked(): bool;

    /**
     * 对于某些按时间收费服务，判断是否服务到期
     *
     * @return bool
     */
    public function isExpired(): bool;
}