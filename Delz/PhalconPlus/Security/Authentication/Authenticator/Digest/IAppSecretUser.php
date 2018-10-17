<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication\Authenticator\Digest;

/**
 * 拥有appSecret的用户
 *
 * @package Delz\PhalconPlus\Security\Authentication\Authenticator\Digest
 */
interface IAppSecretUser
{
    /**
     * 获取app secret
     *
     * @return string
     */
    public function getAppSecret():string;

    /**
     * 获取app master secret
     *
     * @return string
     */
    public function getAppMasterSecret():string;
}