<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\SMS\Contract;

/**
 * 短信发管理类接口
 *
 * @package Delz\PhalconPlus\SMS\Contract
 */
interface IManager
{
    /**
     * 获取发送服务对象
     *
     * @return IProvider
     */
    public function getProvider(): IProvider;

    /**
     * 设置发送服务对象
     *
     * @param IProvider $provider
     */
    public function setProvider(IProvider $provider);

    /**
     * 创建消息对象
     *
     * @return IMessage
     */
    public function createMessage(): IMessage;

    /**
     * 获取报告
     *
     * @return IReport[]
     */
    public function getReports(): array;

    /**
     * 发送短信
     *
     * @param string $mobile
     * @param string $content
     * @return IResult
     */
    public function send(string $mobile, string $content): IResult;
}