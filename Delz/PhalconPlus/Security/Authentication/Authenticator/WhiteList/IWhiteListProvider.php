<?php

namespace Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList;

use Delz\PhalconPlus\Security\Authentication\IToken;

/**
 * 白名单供应者
 *
 * @package Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList
 */
interface IWhiteListProvider
{
    /**
     * 获取白名单
     *
     * @param  IToken $token
     * @return array|null
     */
    public function getList(IToken $token): ?array;
}