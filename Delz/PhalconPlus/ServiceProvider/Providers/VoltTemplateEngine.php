<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\Mvc\View\Volt\ExtensionManager;
use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\DiInterface;
use Delz\PhalconPlus\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ViewBaseInterface;
use Delz\PhalconPlus\App\IApp;
use Delz\PhalconPlus\Config\IConfig;
use Phalcon\Mvc\View\Engine\Volt\Compiler;

/**
 * volt模板引擎
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class VoltTemplateEngine extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'voltEngine';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $self = $this;
        $this->di->setShared(
            $this->serviceName,
            function (ViewBaseInterface $view, DiInterface $di = null) use ($self) {
                /** @var IApp $app */
                $app = $self->di->getShared('app');
                /** @var IConfig $config */
                $config = $self->di->getShared('config');
                $volt = new Volt($view, $di);
                $volt->setOptions(
                    [
                        'compiledPath' => $app->getCacheDir(),
                        'compiledSeparator' => '_',
                        'prefix' => $app->getAppId(),
                        //通常情况下，出于性能方面的考虑，Volt模板引擎在重新编译模板时只会检查子模板中的内容变更。
                        // 所以建议设置Volt模板引擎的选项参数 'compileAlways' => true。
                        //这样模板会实时编译，并检查父模板中的内容变更。
                        'compileAlways' => $config->get('view.volt.compile_always', false)
                    ]
                );
                return $volt;
            }
        );
    }
}