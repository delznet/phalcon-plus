<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\SMS\Contract;

/**
 * 发送报告类接口
 *
 * @package Delz\PhalconPlus\SMS\Contract
 */
interface IReport
{
    /**
     * 消息代号
     *
     * @return string
     */
    public function getId(): string;

    /**
     * 用户是否接收到
     *
     * @return boolean
     */
    public function isSuccess(): bool;

    /**
     * 第三方发送方名称
     *
     * @return string
     */
    public function getProviderName(): string;

    /**
     * 发送失败原因
     *
     * @return string
     */
    public function getErrorMessage(): ?string;

    /**
     * 接收到的时间
     *
     * @return \DateTime
     */
    public function getDeliveredAt(): ?\DateTime;
}