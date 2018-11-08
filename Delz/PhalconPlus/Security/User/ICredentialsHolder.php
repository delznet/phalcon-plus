<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Security\User;

/**
 * 认证凭据接口
 *
 * 如果一个对象需要密码认证，可实现本接口
 *
 * @package Delz\PhalconPlus\Security\User
 */
interface ICredentialsHolder
{
    /**
     * 获取明文密码
     *
     * @return null|string
     */
    public function getPlainPassword(): ?string;

    /**
     * 设置明文密码
     *
     * @param null|string $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void;

    /**
     * 获取加密后的密码
     *
     * @return null|string
     */
    public function getPassword(): ?string;

    /**
     * 设置加密后的密码
     *
     * @param null|string $encodePassword
     */
    public function setPassword(?string $encodePassword): void;

    /**
     * 获取盐值
     *
     * @return null|string
     */
    public function getSalt(): ?string;

    /**
     * 设置盐值
     *
     * @param null|string $salt
     */
    public function setSalt(?string $salt): void;

    /**
     * 清除明文密码
     */
    public function eraseCredentials(): void;
}