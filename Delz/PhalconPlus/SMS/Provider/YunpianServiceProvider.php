<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\SMS\Provider;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Config\IConfig;

/**
 * 云片网短信服务提供者
 *
 * @package Delz\PhalconPlus\SMS\Provider
 */
class YunpianServiceProvider extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'yunpian';

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
                $options = [];
                $options['apikey'] = $config->get('sms.yunpian.apikey');
                return new Tong3($options);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '云片网短信服务';
    }
}