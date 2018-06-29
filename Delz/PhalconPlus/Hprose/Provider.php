<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Hprose;

use Phalcon\DiInterface;

/**
 * rpc服务提供者抽象类
 *
 * @package Delz\PhalconPlus\Hprose
 */
abstract class Provider implements IProvider
{
    /**
     * 服务别名
     *
     * @var string
     */
    protected $name;

    /**
     * @var DiInterface
     */
    protected $di;

    /**
     * @var Server
     */
    protected $server;

    /**
     * @param DiInterface $di 服务容器
     * @param Server $server hprose server
     */
    public function __construct(DiInterface $di, Server $server)
    {
        $this->di = $di;
        $this->server = $server;
    }

    /**
     * {@inheritdoc}
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getServer():Server
    {
        return $this->server;
    }


}