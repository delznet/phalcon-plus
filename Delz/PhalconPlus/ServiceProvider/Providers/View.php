<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\Mvc\View as PhalconView;
use Delz\PhalconPlus\App\IApp;

/**
 * 视图服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class View extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'view';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $self = $this;
        $this->di->setShared(
            $this->serviceName,
            function () use ($self) {
                /** @var IApp $app */
                $app = $self->di->getShared('app');
                $view = new PhalconView();
                $view->setViewsDir($app->getViewDir());
                $view->registerEngines(
                    [
                        '.volt' => 'voltEngine',
                        '.php' => 'phpEngine'
                    ]
                );
                return $view;
            }
        );
    }
}