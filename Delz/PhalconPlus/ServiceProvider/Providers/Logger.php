<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\Events;
use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\App\IApp;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Logger\Adapter\Stream as StreamAdapter;
use Phalcon\Logger\Adapter\Firephp;
use Phalcon\Logger\Adapter\Syslog;
use Delz\PhalconPlus\Event\Manager as EventManagerService;

/**
 * 日志服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Logger extends Provider
{
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
                //日志适配器
                $adapterKey = strtolower($config->get($self->getName() . '.type', 'file'));
                switch ($adapterKey) {
                    case 'file':
                        $logger = $self->createFileLogger();
                        break;
                    case 'firephp':
                        $logger = $self->createFirePHPLogger();
                        break;
                    case 'stream':
                        $logger = $self->createStreamLogger();
                        break;
                    default:
                        throw new \InvalidArgumentException(
                            sprintf('Not support logger adapter: %s', $adapterKey)
                        );
                }

                // 开启事务
                $logger->begin();

                /** @var EventManagerService $eventsManager */
                $eventsManager = $self->di->getShared('eventsManager');
                //默认权重是100，设置权重为0，把日志放在最后执行
                $eventsManager->attach(Events::APPLICATION_TERMINATE, function () use ($logger) {
                    $logger->commit();
                    $logger->close();
                }, 0);

                return $logger;

            }
        );
    }

    /**
     * 创建文件日志服务
     *
     * @return FileAdapter
     */
    protected function createFileLogger():FileAdapter
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        /** @var IApp $app */
        $app = $this->di->getShared('app');
        //获取日志文件地址
        $logFile = $app->getLogDir() . $config->get($this->getName() . '.file', $this->getName() . '.log');
        return new FileAdapter($logFile);
    }

    /**
     * 创建PHP流日志服务
     *
     * @return StreamAdapter
     */
    protected function createStreamLogger():StreamAdapter
    {
        return new StreamAdapter('php://stdout');
    }

    /**
     * 发送日志到FirePHP
     *
     * @return Firephp
     */
    protected function createFirePHPLogger():Firephp
    {
        return new Firephp();
    }

    /**
     * 发送日志到FirePHP
     *
     * @return Syslog
     */
    protected function createSyslogLogger():Syslog
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        /** @var IApp $app */
        $app = $this->di->getShared('app');
        $name = $config->get($this->getName() . '.name', $app->getAppId());
        return new Syslog($name, [
            "option" => LOG_CONS | LOG_NDELAY | LOG_PID,
            "facility" => LOG_USER
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '日志';
    }
}