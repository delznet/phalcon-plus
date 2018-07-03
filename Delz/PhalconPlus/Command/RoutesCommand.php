<?php

namespace Delz\PhalconPlus\Command;

use Delz\Console\Contract\IInput;
use Delz\Console\Contract\IOutput;
use Phalcon\Mvc\Router;
use Delz\PhalconPlus\App\IApp;

/**
 * 获取所有路由命令
 *
 * @package Delz\PhalconPlus\Command
 */
class RoutesCommand extends DiAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function execute(IInput $input, IOutput $output)
    {
        if ($input->hasArgument('module')) {
            /** @var IApp $app */
            $app = $this->getDi()->get('app');
            $app->setModule($input->getArgument('module'));
        }
        /** @var Router $router */
        $router = $this->getDi()->get('router');
        $router->handle();
        $routes = $router->getRoutes();

        /** @var Router\RouteInterface $route */
        foreach ($routes as $route) {
            $httpMethods = $route->getHttpMethods();
            $httpMethod = is_string($httpMethods) ? $httpMethods : implode(' ', $httpMethods);
            $name = $route->getName() ? '[name=' . $route->getName() . ']' : '';
            $output->writeln('[' . $httpMethod . '] ' . $name . ' <info>' . $route->getPattern() . '</info> = <comment>' . json_encode($route->getPaths()) . '</comment>');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('routes')
            ->setDescription('获取所有的路由');
    }


}