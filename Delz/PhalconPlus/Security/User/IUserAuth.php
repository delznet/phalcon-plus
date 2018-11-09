<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Security\User;

/**
 * 可以通过第三方oauth，username，email，mobile查找用户
 *
 * IUserAuth保存这些唯一标记
 *
 * @package Delz\PhalconPlus\Security\User
 */
interface IUserAuth extends IUserAware
{
    /**
     * 获取唯一id
     *
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * 唯一值类型
     *
     * @return string
     */
    public function getIdentityType(): string;
}