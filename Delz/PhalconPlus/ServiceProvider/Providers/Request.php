<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\Http\Request as BaseRequest;

/**
 * Request服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Request extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'request';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                return new BaseRequest();
            }
        );
    }

}