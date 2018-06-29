<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Config;

/**
 * Yaconf扩展配置类
 *
 * 使用本类必须安装Yaconf扩展，具体安装请参考https://github.com/laruence/yaconf
 *
 * 本类须php版本须php7+
 *
 * @package Delz\PhalconPlus\Config
 */
class Yaconf implements IConfig
{
    /**
     * Yaconf的配置文件名，如
     *
     * 配置文件名 app.ini，那么namespace可以设置为app
     *
     * @var string
     */
    private $namespace;

    /**
     * @param string $namespace
     */
    public function __construct(string $namespace)
    {
        if (!extension_loaded("yaconf")) {
            throw new \RuntimeException("Please install yaconf extension.");
        }
        $this->namespace = $namespace;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key = null, $default = null)
    {
        if ($key === null) {
            return \Yaconf::get($this->namespace);
        }
        return \Yaconf::get($this->getKey($key), $default);
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $key):bool
    {
        return \Yaconf::has($this->getKey($key));
    }

    /**
     * 获取namespace获取Yaconf能读取的key值
     *
     * @param string $key
     * @return string
     */
    private function getKey(string $key):string
    {
        return $this->namespace . '.' . $key;
    }
}