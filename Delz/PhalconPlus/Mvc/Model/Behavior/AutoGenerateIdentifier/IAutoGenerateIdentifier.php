<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\AutoGenerateIdentifier;

/**
 * 自增Id模型
 *
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\AutoGenerateIdentifier
 */
interface IAutoGenerateIdentifier
{
    /**
     * 返回自增Id
     *
     * @return int
     */
    public function getId():int;
}