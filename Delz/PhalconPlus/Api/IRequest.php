<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Api;

use Phalcon\Di\InjectionAwareInterface;

/**
 * API请求数据模型接口类
 *
 * @package Delz\PhalconPlus\Api
 */
interface IRequest extends InjectionAwareInterface
{
    /**
     * 获取解析后的数据
     *
     * @return mixed
     */
    public function getData();

    /**
     * 验证数据是否正确,不正确
     *
     * @return bool
     */
    public function validate(): bool;

    /**
     * 验证失败后处理
     */
    public function onValidateFail();

}