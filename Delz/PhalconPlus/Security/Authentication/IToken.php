<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication;

use Delz\PhalconPlus\Security\User\IUser;

/**
 * Token接口
 *
 * @package Delz\PhalconPlus\Security\Authentication
 */
interface IToken
{
    /**
     * 用户唯一代号，可以是用户名、手机、邮箱、第三方系统openid、开发用的appid
     *
     * @return string
     */
    public function getIdentifier():string;

    /**
     * @return IUser
     */
    public function getUser():IUser;

    /**
     * @param IUser $IUser
     */
    public function setUser(IUser $IUser);

    /**
     * 是否已经认证
     *
     * @return bool
     */
    public function isAuthenticated():bool;

    /**
     * 设置是否认证
     *
     * @param bool $isAuthenticated
     */
    public function setAuthenticated(bool $isAuthenticated);
}