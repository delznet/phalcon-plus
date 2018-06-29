<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\DiInterface;
use Phalcon\Mvc\ViewBaseInterface;

/**
 * php模板引擎服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class PhpTemplateEngine extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'phpEngine';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function (ViewBaseInterface $view, DiInterface $di = null) {
                $engine = new PhpEngine($view, $di);
                return $engine;
            }
        );
    }
}