<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\SMS\Contract;

/**
 * 发送结果接口类
 *
 * @package Delz\PhalconPlus\SMS\Contract
 */
interface IResult
{
    /**
     * 是否发送成功
     *
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * 返回发送结果的目标消息对象
     *
     * @return IMessage
     */
    public function getMessage(): IMessage;
}