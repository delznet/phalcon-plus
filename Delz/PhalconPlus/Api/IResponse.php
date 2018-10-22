<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Api;

/**
 * API返回结构接口类
 *
 * @package Delz\PhalconPlus\Api
 */
interface IResponse extends \JsonSerializable
{
    /**
     * 返回状态码
     *
     * @return int
     */
    public function getRet();

    /**
     * 状态描述
     *
     * @return string
     */
    public function getMsg();

    /**
     * 返回给客户端的数据
     *
     * @return mixed
     */
    public function getData();
}