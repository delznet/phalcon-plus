<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\SMS\Provider;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Config\IConfig;

/**
 * 大汉三通短信服务Provider
 * @package Delz\PhalconPlus\SMS\Provider
 */
class Tong3ServiceProvider extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'tong3';

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
                $options['account'] = $config->get('sms.tong3.account');
                $options['password'] = $config->get('sms.tong3.password');
                $options['sign'] = $config->get('sms.tong3.sign');
                $options['subCode'] = $config->get('sms.tong3.subcode');
                return new Tong3($options);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '大汉三通短信服务';
    }
}