<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\Flash\Session as FlashSession;

/**
 * 闪存消息服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Flash extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'flash';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                return new FlashSession();
            }
        );
    }
}