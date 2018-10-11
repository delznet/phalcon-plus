<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model;

use Delz\PhalconPlus\Mvc\Model;
use Delz\PhalconPlus\Mvc\Model\Behavior\AutoGenerateIdentifier\IAutoGenerateIdentifier;
use Delz\PhalconPlus\Mvc\Model\Behavior\AutoGenerateIdentifier\TAutoGenerateIdentifier;
use Delz\PhalconPlus\Mvc\Model\Behavior\Timestampable\ITimestampable;
use Delz\PhalconPlus\Mvc\Model\Behavior\Timestampable\TTimestampable;

/**
 * 常见model
 *
 * 封装了IAutoGenerateIdentifier Behavior和ITimestampable Behavior
 *
 * @package Delz\PhalconPlus\Mvc\Model
 */
class Common extends Model implements IAutoGenerateIdentifier, ITimestampable
{
    use TAutoGenerateIdentifier, TTimestampable;
}