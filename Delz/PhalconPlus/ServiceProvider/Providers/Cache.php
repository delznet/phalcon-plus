<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\App\IApp;
use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Config\IConfig;
use Phalcon\Cache\Frontend\Data as FrontData;
use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Backend\Libmemcached;
use Phalcon\Cache\Backend\Apc;
use Phalcon\Cache\Backend\Redis;
use Phalcon\Cache\Backend\Memory;
use Phalcon\Cache\Backend\Xcache;

/**
 * 缓存服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Cache extends Provider
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
                //获取使用的数据库适配器
                $adapterKey = strtolower($config->get($self->getName() . '.adapter', 'memory'));
                switch ($adapterKey) {
                    case 'memory':
                        $cache = $self->createMemoryCache();
                        break;
                    case 'file':
                        $cache = $self->createFileCache();
                        break;
                    case 'apc':
                        $cache = $self->createApcCache();
                        break;
                    case 'libmemcached':
                        $cache = $self->createLibmemcachedCache();
                        break;
                    case 'redis':
                        $cache = $self->createRedisCache();
                        break;
                    case 'xcache':
                        $cache = $self->createXcache();
                        break;
                    default:
                        throw new \InvalidArgumentException(
                            sprintf('Not support cache adapter: %s', $adapterKey)
                        );
                }

                return $cache;

            }
        );
    }

    /**
     * 文件缓存
     *
     * @return File
     */
    private function createFileCache():File
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        /** @var IApp $app */
        $app = $this->di->getShared('app');
        $lifetime = (int)$config->get($this->getName() . '.lifetime', 3600);
        $cacheDir = $app->getCacheDir();
        $frontCache = new FrontData([
            "lifetime" => $lifetime
        ]);
        return new File($frontCache, ['cacheDir' => $cacheDir]);

    }

    /**
     * apc缓存
     *
     * @return Apc
     */
    private function createApcCache():Apc
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        /** @var IApp $app */
        $app = $this->di->getShared('app');
        $lifetime = (int)$config->get($this->getName() . '.lifetime', 3600);
        $frontCache = new FrontData([
            "lifetime" => $lifetime
        ]);
        return new Apc($frontCache, ['prefix' => $app->getAppId()]);

    }

    /**
     * Xcache缓存
     *
     * @return Xcache
     */
    private function createXcache():Xcache
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        /** @var IApp $app */
        $app = $this->di->getShared('app');
        $lifetime = (int)$config->get($this->getName() . '.lifetime', 3600);
        $frontCache = new FrontData([
            "lifetime" => $lifetime
        ]);
        return new Xcache($frontCache, ['prefix' => $app->getAppId()]);

    }

    /**
     * redis缓存
     *
     * @return Redis
     */
    private function createRedisCache():Redis
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        $lifetime = (int)$config->get($this->getName() . '.lifetime', 3600);
        $frontCache = new FrontData([
            "lifetime" => $lifetime
        ]);
        return new Redis($frontCache, [
            'host' => $config->get($this->getName() . '.host', '127.0.0.1'),
            'port' => $config->get($this->getName() . '.port', '6379'),
            'auth' => $config->get($this->getName() . '.auth', ''),
            'persistent' => $config->get($this->getName() . '.persistent', false)
        ]);

    }

    /**
     * Memory缓存
     *
     * @return Memory
     */
    private function createMemoryCache():Memory
    {
        $frontCache = new FrontData();
        return new Memory($frontCache);

    }

    /**
     * Libmemcached缓存
     *
     * @return Libmemcached
     */
    private function createLibmemcachedCache():Libmemcached
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        /** @var IApp $app */
        $app = $this->di->getShared('app');
        $lifetime = (int)$config->get($this->getName() . '.lifetime', 3600);
        $servers = $config->get($this->getName() . '.servers');
        $frontCache = new FrontData([
            "lifetime" => $lifetime
        ]);
        return $cache = new Libmemcached(
            $frontCache,
            [
                "servers" => $servers,
                "client" => [
                    \Memcached::OPT_HASH => \Memcached::HASH_MD5,
                    \Memcached::OPT_PREFIX_KEY => $app->getAppId()
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '缓存';
    }
}