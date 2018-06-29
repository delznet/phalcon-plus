<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\Http\Response as BaseResponse;

/**
 * Response 服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Response extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'response';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                return new BaseResponse();
            }
        );
    }
}