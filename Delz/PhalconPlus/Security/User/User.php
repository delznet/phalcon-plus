<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\User;

/**
 * 用户抽象类
 *
 * @package Delz\PhalconPlus\Security\User
 */
abstract class User implements IUser
{
    /**
     * 角色
     *
     * @var array
     */
    protected $roles = [];

    /**
     * 用户是否激活
     *
     * @var bool
     */
    protected $enabled = false;

    /**
     * {@inheritdoc}
     */
    public function getRoles():array
    {
        return $this->roles;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled():bool
    {
        return $this->enabled;
    }


}