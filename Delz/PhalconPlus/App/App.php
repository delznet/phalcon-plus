<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\App;

use Delz\PhalconPlus\Event\Manager;
use Delz\PhalconPlus\Events;
use Delz\PhalconPlus\Exception\InvalidAppIdException;
use Delz\PhalconPlus\Di;
use Delz\PhalconPlus\Config\Yaconf;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\IoC;
use Phalcon\Debug;

/**
 * 应用抽象类
 *
 * @package Delz\PhalconPlus\App
 */
abstract class App implements IApp
{
    /**
     * 依赖注入容器
     *
     * @var Di
     */
    protected $di;

    /**
     * 应用标记
     *
     * 同一台服务器上名称需要唯一
     * 如果用到Yaconf配置类，配置文件名需取应用标记的名称
     *
     * @var string
     */
    protected $appId;

    /**
     * 模块，默认模块等于default
     *
     * @var string
     */
    protected $module = 'default';

    /**
     * 根目录
     *
     * @var string
     */
    protected $rootDir;

    /**
     * App constructor.
     * @param string $appId 应用Id，支持字母、数字以及字符串-和_
     */
    public function __construct(string $appId = null)
    {
        if ($appId) {
            $this->setAppId($appId);
        }

        //初始化容器服务
        $this->di = new Di();
        IoC::setDi($this->di);

        //将本身加入服务，服务名为app
        $this->di->setShared('app', $this);

        //初始化一些基础服务
        $this->initConfigService();

        //是否debug
        /** @var IConfig $config */
        $config = $this->di->get('config');
        $debug = $config->get('app.debug', false);
        if($debug) {
            $debug = new Debug();
            $debug->listen();
        }

        register_shutdown_function([$this, 'terminate']);
    }

    /**
     * {@inheritdoc}
     */
    public function getAppId():string
    {
        return $this->appId;
    }

    /**
     * {@inheritdoc}
     */
    public function setAppId(string $appId):IApp
    {
        if (!$this->checkAppId($appId)) {
            throw new InvalidAppIdException($appId);
        }

        $this->appId = $appId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getModule():string
    {
        return $this->module;
    }

    /**
     * {@inheritdoc}
     */
    public function setModule(string $moduleName):IApp
    {
        $this->module = $moduleName;

        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function getDi():Di
    {
        return $this->di;
    }

    /**
     * {@inheritdoc}
     */
    public function getRootDir():string
    {
        if ($this->rootDir === null) {
            throw new \InvalidArgumentException('RootDir is null. use setRootDir() first.');
        }
        return $this->rootDir;
    }

    /**
     * {@inheritdoc}
     */
    public function setRootDir(string $dir):IApp
    {
        if (is_dir($dir)) {
            $this->rootDir = realpath($dir);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir():string
    {
        /** @var IConfig $config */
        $config = $this->di->get('config');
        $cacheDir = $config->get('app.cache_dir', 'var/cache');
        return $this->getRootDir() . DIRECTORY_SEPARATOR . $cacheDir . DIRECTORY_SEPARATOR;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir():string
    {
        /** @var IConfig $config */
        $config = $this->di->get('config');
        $logDir = $config->get('app.log_dir', 'var/logs');
        return $this->getRootDir() . DIRECTORY_SEPARATOR . $logDir . DIRECTORY_SEPARATOR;
    }

    /**
     * {@inheritdoc}
     */
    public function getViewDir():string
    {
        /** @var IConfig $config */
        $config = $this->di->get('config');
        $viewDir = $config->get('view.dir', 'resources/views');
        return $this->getRootDir() . DIRECTORY_SEPARATOR . $viewDir . DIRECTORY_SEPARATOR . $this->getModule();
    }

    /**
     * {@inheritdoc}
     */
    public function getEntryDir():string
    {
        /** @var IConfig $config */
        $config = $this->di->get('config');
        $entryDir = $config->get('app.entry_dir', 'public');
        return $this->getRootDir() . DIRECTORY_SEPARATOR . $entryDir;
    }

    /**
     * 初始化config服务
     *
     * config是核心服务，固定了使用Yaconf
     */
    protected function initConfigService()
    {
        $configService = new Yaconf($this->appId);
        $this->di->setShared('config', $configService);
    }

    /**
     * 应用结束后执行
     */
    public function terminate()
    {
        /** @var Manager $eventsManager */
        $eventsManager = $this->di->get('eventsManager');
        $eventsManager->fire(Events::APPLICATION_TERMINATE, $this);
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion():string
    {
        return '1.0';
    }


    /**
     * 检查appId是否合法
     *
     * @param string $appId
     * @return bool 合法返回true，反之false
     */
    private function checkAppId(string $appId):bool
    {
        return (bool)preg_match('/^[_-a-zA-Z0-9]+$/i', $appId);
    }
}