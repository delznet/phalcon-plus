<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\SMS;

use Delz\PhalconPlus\ServiceProvider\Provider as BaseServiceProvider;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\SMS\Exception\ProviderNotFoundException;
use Delz\PhalconPlus\SMS\Exception\ProviderNotSetException;

/**
 * 短信服务provider
 * @package Delz\PhalconPlus\SMS
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'sms';

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
                $smsProvider = $config->get('sms.provider');
                if (!$smsProvider) {
                    throw new ProviderNotSetException();
                }
                //找到sms.providers中定义的对应真正的短信服务名称
                $smsProviderServiceName = $config->get('sms.providers.' . $smsProvider);
                if (!$smsProviderServiceName) {
                    throw new ProviderNotFoundException();
                }
                //获取真正的短信服务提供者
                $smsProviderService = $this->di->get($smsProviderServiceName);
                return new Manager($smsProviderService);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '短信发送服务';
    }
}