<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\Mvc\View as PhalconView;
use Delz\PhalconPlus\App\IApp;
use Delz\PhalconPlus\Event\Manager as EventManager;
use Phalcon\Mvc\Router;

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
                /** @var EventManager $eventManager */
                $eventManager = $self->di->get('eventsManager');
                $eventManager->attach('application:beforeHandleRequest', function () use ($self, $view) {
                    /** @var Router $router */
                    $router = $self->di->get('router');
                    if ($route = $router->getMatchedRoute()) {
                        $paths = $route->getPaths();
                        $namespace = $paths['namespace'];
                        $controller = ucfirst($paths['controller']);
                        $action = $paths['action'];
                        $defaults = $router->getDefaults();
                        $defaultNamespace = $defaults['namespace'];
                        if ($namespace != $defaultNamespace && strpos($namespace, $defaultNamespace) === 0) {
                            $len = strlen($namespace) - strlen($defaultNamespace) - 1;
                            $viewDir = substr($namespace, -$len) . '/' . $controller . '/' . $action;
                            $view->pick($viewDir);
                        }
                    }
                });
                return $view;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '视图';
    }
}