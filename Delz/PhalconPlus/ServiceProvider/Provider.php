<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider;

use Phalcon\DiInterface;

/**
 * 服务提供者抽象类
 *
 * @package Delz\PhalconPlus\ServiceProvider
 */
abstract class Provider implements IProvider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName;

    /**
     * @var DiInterface
     */
    protected $di;

    /**
     * @param DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        $this->di = $di;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->serviceName;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name)
    {
        $this->serviceName = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '';
    }


}