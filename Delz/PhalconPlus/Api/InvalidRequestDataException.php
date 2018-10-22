<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Api;

use Delz\PhalconPlus\Exception\BadRequestException;

/**
 * Class InvalidRequestDataException
 * @package Delz\PhalconPlus\Api
 */
class InvalidRequestDataException extends BadRequestException
{
    /**
     * {@inheritdoc}
     */
    public function __construct($message, $code = 1)
    {
        parent::__construct($message, $code);
    }

}