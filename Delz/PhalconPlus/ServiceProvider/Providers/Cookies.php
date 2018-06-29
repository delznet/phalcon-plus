<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\Http\Response\Cookies as BaseCookies;

/**
 * Cookie服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Cookies extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'cookies';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                $cookies = new BaseCookies();
                $cookies->useEncryption(true);
                return $cookies;
            }
        );
    }
}