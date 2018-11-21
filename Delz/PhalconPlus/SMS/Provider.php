<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\SMS;

use Delz\PhalconPlus\SMS\Contract\IProvider;
use Delz\PhalconPlus\SMS\Exception\InvalidOptionsException;

/**
 * 短信服务提供者抽象类
 *
 * @package Delz\PhalconPlus\SMS
 */
abstract class Provider implements IProvider
{
    /**
     * @var array
     */
    protected $options;

    /**
     * 可以覆盖写此构造函数
     *
     * @param array $options
     * @throws InvalidOptionsException
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }
}