<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Sequence;

use Delz\PhalconPlus\Exception\BadRequestException;

/**
 * 生成器没有配置
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Sequence
 */
class NonExistingGeneratorException extends BadRequestException
{
    public function __construct($name, int $code = 0)
    {
        parent::__construct(
            sprintf(
                'Generator "%s" does not exist. Please consider adding it to your configuration like this: model.sequence.%s = your generate service name',
                $name, $name
            ), $code);
    }

}