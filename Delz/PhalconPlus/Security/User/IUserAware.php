<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Security\User;

/**
 * Interface IUserAware
 * @package Delz\PhalconPlus\Security\User
 */
interface IUserAware
{
    /**
     * @return mixed
     */
    public function getUser();

    /**
     * @param mixed $user
     */
    public function setUser($user);
}