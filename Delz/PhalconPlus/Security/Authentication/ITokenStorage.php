<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication;

/**
 * Token存储接口
 *
 * @package Delz\PhalconPlus\Security\Authentication
 */
interface ITokenStorage
{
    /**
     * @return IToken
     */
    public function getToken():IToken;

    /**
     * @param IToken $token
     */
    public function setToken(IToken $token);
}