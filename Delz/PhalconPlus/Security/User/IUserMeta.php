<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Security\User;

/**
 * Interface IUserMeta
 * @package Delz\PhalconPlus\Security\User
 */
interface IUserMeta extends IUserAware
{
    /**
     * @return string
     */
    public function getMetaKey(): string;

    /**
     * @return string
     */
    public function getMetaValue(): string;
}