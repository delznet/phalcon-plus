<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication;

/**
 * Class TokenStorage
 * @package Delz\PhalconPlus\Security\Authentication
 */
class TokenStorage implements ITokenStorage
{
    /**
     * @var IToken
     */
    protected $token;

    /**
     * {@inheritdoc}
     */
    public function getToken():IToken
    {
        return $this->token;
    }

    /**
     * {@inheritdoc}
     */
    public function setToken(IToken $token)
    {
        $this->token = $token;
    }

}