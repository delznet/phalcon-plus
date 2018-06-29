<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Exception;

/**
 * appId非法异常
 *
 * @package Delz\PhalconPlus\Exception
 */
class InvalidAppIdException extends \InvalidArgumentException
{
    /**
     * InvalidAppIdException constructor.
     * @param string $appId 应用Id
     */
    public function __construct(string $appId)
    {
        parent::__construct(
            sprintf('Invalid AppId: %s. AppId should be alphabet，digit, "-" or "_"', $appId)
        );
    }
}