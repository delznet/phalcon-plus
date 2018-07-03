<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Config\IConfig;
use Phalcon\Crypt as PhalconCrypt;

/**
 * 加密服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Crypt extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'crypt';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        $this->di->setShared(
            $this->serviceName,
            function () use ($config) {
                $secretKey = $config->get('security.secret');
                $crypt = new PhalconCrypt();
                $crypt->setKey($secretKey);
                return $crypt;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '加密';
    }

}