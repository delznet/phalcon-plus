<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\SMS\Exception;

/**
 * 短信供应商没有提供异常
 *
 * 在服务提供者查找服务的时候没有找到短信供应商配置
 *
 * @package Delz\PhalconPlus\SMS\Exception
 */
class ProviderNotSetException extends \RuntimeException
{

}