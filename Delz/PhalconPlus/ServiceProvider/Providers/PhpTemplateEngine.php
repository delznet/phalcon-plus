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
        $self = $this;
        $this->di->setShared(
            $this->serviceName,
            function (ViewBaseInterface $view = null, DiInterface $di = null) use ($self) {
                if (is_null($view)) {
                    $view = $self->di->get('view');
                }
                $engine = new PhpEngine($view, $di);
                return $engine;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'php模板引擎';
    }
}