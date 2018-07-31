<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication;

use Delz\PhalconPlus\Security\User\IUser;

/**
 * Class Token
 * @package Delz\PhalconPlus\Security\Authentication
 */
abstract class Token implements IToken
{
    /**
     * 是否认证过
     *
     * @var bool
     */
    protected $authenticated = false;

    /**
     * @var IUser
     */
    protected $user;

    /**
     * {@inheritdoc}
     */
    public function getUser():IUser
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(IUser $user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function isAuthenticated():bool
    {
        return $this->authenticated;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthenticated(bool $authenticated)
    {
        $this->authenticated = $authenticated;
    }

}