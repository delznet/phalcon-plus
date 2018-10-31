<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Sequence;

use Delz\PhalconPlus\Exception\BadRequestException;

/**
 * Class SequenceCacheNotSetException
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Sequence
 */
class SequenceCacheNotSetException extends BadRequestException
{
    public function __construct(string $message = 'Please consider adding it to your configuration like this: model.sequence.cache = your cache service', int $code = 0)
    {
        parent::__construct($message, $code);
    }
}