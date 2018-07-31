<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\User;

/**
 * 用户提供者
 *
 * @package Delz\PhalconPlus\Security\User
 */
interface IUserProvider
{
    /**
     * 通过唯一标识找到用户
     *
     * 唯一标记可以是用户名、email、手机号码或第三方openId
     *
     * 可以用以下方式定义$uniqueIdentifier
     * xxx@username   用户名
     * xxx@email      email
     * xxx@mobile     手机号码
     * xxx@wechat     微信
     *
     * @param string $uniqueIdentifier 唯一标识区分
     * @return IUser|null
     */
    public function find(string $uniqueIdentifier):IUser;
}