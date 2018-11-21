<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\SMS;

use Delz\PhalconPlus\SMS\Contract\IReport;

/**
 * 短信发送报告
 *
 * @package Delz\PhalconPlus\SMS
 */
class Report implements IReport
{
    /**
     * 消息代号
     *
     * @var string
     */
    protected $id;

    /**
     * 接收到的时间
     *
     * @var \DateTime
     */
    protected $deliveredAt;

    /**
     * 发送失败原因
     *
     * @var string
     */
    protected $errorMessage;

    /**
     * 第三方发送方名称
     *
     * @var string
     */
    protected $providerName;

    /**
     * 用户是否接收到
     *
     * @var bool
     */
    protected $success;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDeliveredAt(): ?\DateTime
    {
        return $this->deliveredAt;
    }

    /**
     * @param \DateTime $deliveredAt
     */
    public function setDeliveredAt(?\DateTime $deliveredAt)
    {
        $this->deliveredAt = $deliveredAt;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     */
    public function setErrorMessage(?string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return string
     */
    public function getProviderName(): string
    {
        return $this->providerName;
    }

    /**
     * @param string $providerName
     */
    public function setProviderName(string $providerName)
    {
        $this->providerName = $providerName;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success)
    {
        $this->success = $success;
    }


}