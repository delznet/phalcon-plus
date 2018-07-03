<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\Mvc\Router\Annotations as PhalconRouterAnnotations;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\App\IApp;

/**
 * 注解路由服务
 *
 * 此服务依赖于annotations服务，必须注册了annotations才能使用
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class RouterAnnotations extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'router';

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
                /** @var IApp $app */
                $app =  $self->di->getShared('app');
                //设置为false，关掉/:controller/:action/:params格式的默认路由行为
                $router = new PhalconRouterAnnotations(false);
                //处理结尾额外的斜杆
                $router->removeExtraSlashes(true);
                //设置默认namespace，controller以及action
                $router->setDefaultNamespace($config->get('router.' . $app->getModule() . '.default_namespace', 'App\Controller'));
                $router->setDefaultController($config->get('router.' . $app->getModule() . '.default_controller', 'Index'));
                $router->setDefaultAction($config->get('router.' . $app->getModule() . '.default_action', 'index'));
                //设置404
                $router->notFound([
                    'controller' => $config->get('router.' . $app->getModule() . '.not_found_controller', 'Error'),
                    'action' => $config->get('router.' . $app->getModule() . '.not_found_action', 'notFound'),
                ]);
                //添加注解路由
                $routers = $config->get('router.' . $app->getModule() . '.annotations');
                if ($routers && is_array($routers)) {
                    //@todo 如果handler包含路径？
                    foreach ($routers as $handler => $prefix) {
                        $router->addResource($handler, $prefix);
                    }
                }

                return $router;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '注解路由';
    }
}