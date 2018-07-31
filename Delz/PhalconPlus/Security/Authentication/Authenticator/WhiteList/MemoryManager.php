<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList;

/**
 * 白名单内存管理器
 *
 * 将白名单放在内存中
 *
 * @package Delz\PhalconPlus\Security\Authentication\Authenticator\WhiteList
 */
class MemoryManager implements IManager
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