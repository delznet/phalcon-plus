<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus;

use Delz\PhalconPlus\Exception\ServiceProviderClassNotFoundException;
use Phalcon\Di as BaseDi;
use Delz\PhalconPlus\Exception\ServiceNotFoundException;
use Delz\PhalconPlus\Exception\InvalidServiceNameException;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\ServiceProvider\IProvider;

/**
 * 对Phalcon Di进行扩展
 *
 * 将服务容器参数数组化，用Yaconf保存相关服务的配置参数，需要调用的时候将其set到服务器容器，然后get获取他。
 *
 * 这样避免了容器的开销，是容器按需加载，内存使用最小化。
 *
 * 在容器实例化的时候在框架中必须实例化config服务作为基础服务。
 *
 * @package Delz\PhalconPlus
 */
class Di extends BaseDi
{
    /**
     * 重写服务获取
     *
     * 先判断是否已经启动了服务，如果启动了，直接返回服务实例；
     * 如果没有启动，从config服务中查找[services.服务名称]的配置项，如果不存在，直接抛出ServiceNotFoundException异常；
     * 如果配置项存在，配置项的值是ServiceProvider类名，先判断ServiceProvider类是否存在，如果不存在抛出ServiceProvider的getName()方法获取的服务名称是否与[services.服务名称]一致，
     * 如果不一致，抛出InvalidServiceNameException异常，如果一致，则调用ServiceProvider的register()方法注册服务
     *
     * @param string $name
     * @param mixed $parameters
     * @return mixed
     */
    public function get($name, $parameters = null)
    {
        if ($this->has($name)) {
            return parent::get($name, $parameters);
        }
        //有的服务就是一个类
        if (class_exists($name)) {
            return parent::get($name, $parameters);
        }
        $serviceKey = 'services.' . $name;
        /** @var IConfig $configService */
        $configService = parent::get('config');
        if(!$serviceProviderClass = $configService->get($serviceKey)) {
            throw new ServiceNotFoundException($name);
        }
        if(!class_exists($serviceProviderClass)) {
            throw new ServiceProviderClassNotFoundException($serviceProviderClass);
        }
        /** @var IProvider $serviceProvider */
        $serviceProvider = new $serviceProviderClass($this);

        $serviceName = $serviceProvider->getName();
        //如果不设置serviceName,那么serviceName就是等于$name
        if(!$serviceName) {
            $serviceName = $name;
            $serviceProvider->setName($name);
        }
        if($serviceName != $name) {
            throw new InvalidServiceNameException($name, $serviceProvider->getName());
        }

        $serviceProvider->register();

        return parent::get($name, $parameters);
    }

    /**
     * 获取所有的service provider
     *
     * 可以调试打印出所有的服务提供者
     *
     * @return array
     */
    public function getAllServiceProviders():array
    {
        /** @var IConfig $configService */
        $configService = parent::get('config');
        return $configService->get("services");
    }
}