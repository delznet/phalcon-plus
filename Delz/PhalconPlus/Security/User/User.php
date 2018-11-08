<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Security\User;

use Delz\PhalconPlus\Mvc\Model\Common as Model;

/**
 * 用户基础类
 *
 * @package Delz\PhalconPlus\Security\User
 */
class User extends Model implements IUser
{
    use TCredentialsHolder;

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isLocked(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isExpired(): bool
    {
        return false;
    }

}