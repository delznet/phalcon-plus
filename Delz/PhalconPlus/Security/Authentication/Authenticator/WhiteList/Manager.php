<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList;

/**
 * 白名单管理器
 *
 * @package Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList
 */
class Manager implements IManager
{
    /**
     * 白名单
     *
     * @var array
     */
    protected $whiteList = [];

    /**
     * @param array $whiteList
     */
    public function __construct(array $whiteList)
    {
        $this->whiteList = $whiteList;
    }

    /**
     * {@inheritdoc}
     */
    public function check(string $ip):bool
    {
        return in_array($ip, $this->whiteList);
    }

}