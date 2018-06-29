<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Config\IConfig;

/**
 * beanstalk队列服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Beanstalk extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'beanstalk';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $self = $this;
        $this->di->setShared(
            $this->serviceName,
            function () use ($self) {
                /** @var IConfig $config */
                $config = $self->di->getShared('config');
                $queue = new \Phalcon\Queue\Beanstalk([
                    "host" => $config->get('beanstalk.host', '127.0.0.1'),
                    "port" => $config->get('beanstalk.port', '11300'),
                ]);

                return $queue;

            }
        );
    }
}