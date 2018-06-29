<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Hprose;

/**
 * rpc服务提供者，跟服务容器的服务提供者类似
 *
 * @package Delz\PhalconPlus\Hprose
 */
interface IProvider
{
    /**
     * 注册rpc服务
     *
     * @return mixed
     */
    public function register();

    /**
     * 获取服务别名，就是调用的方法名
     *
     * @return string
     */
    public function getName():string;

    /**
     * 设置服务别名
     *
     * @param string $name
     */
    public function setName(string $name);

    /**
     * @return Server
     */
    public function getServer():Server;
}