<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\SMS;

use Delz\PhalconPlus\SMS\Contract\IResult;
use Delz\PhalconPlus\SMS\Contract\IMessage;

/**
 * 结果
 * @package Delz\PhalconPlus\SMS
 */
class Result implements IResult
{
    /**
     *
     * @var IMessage
     */
    protected $message;

    /**
     * @param IMessage $message
     */
    public function __construct(IMessage $message)
    {
        $this->message = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccess(): bool
    {
        return (bool)$this->message->getState() == IMessage::STATE_SENT;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage(): IMessage
    {
        return $this->message;
    }
}