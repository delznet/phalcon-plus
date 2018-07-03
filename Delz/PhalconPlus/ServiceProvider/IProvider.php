<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider;

/**
 * 服务提供者接口
 *
 * @package Delz\PhalconPlus\ServiceProvider
 */
interface IProvider
{
    /**
     * 注册服务
     *
     * @return mixed
     */
    public function register();

    /**
     * 获取服务名称
     *
     * @return string
     */
    public function getName();

    /**
     * 设置服务名称
     *
     * @param string $name
     */
    public function setName(string $name);

    /**
     * 获取服务描述
     *
     * @return string
     */
    public function getDescription();
}