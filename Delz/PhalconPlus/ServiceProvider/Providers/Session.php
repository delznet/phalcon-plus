<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\App\IApp;
use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\Util\Validator;
use Phalcon\Session\Adapter\Files as FilesSession;
use Phalcon\Session\Adapter\Libmemcached as LibmemcachedSession;
use Phalcon\Session\Adapter\Memcache as MemcacheSession;
use Phalcon\Session\Adapter\Redis as RedisSession;

/**
 * session服务
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Session extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'session';

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
                $adapter = $config->get('session.adapter', 'files');
                switch ($adapter) {
                    case 'files':
                        $session = $self->registerFileSession();
                        break;
                    case 'memcached':
                        $session = $self->registerLibmemcachedSession();
                        break;
                    case 'memcache':
                        $session = $self->registerMemcacheSession();
                        break;
                    case 'redis':
                        $session = $self->registerRedisSession();
                        break;
                    default:
                        $session = $self->registerFileSession();
                        break;
                }

                $session->start();

                return $session;
            }
        );
    }

    /**
     * @return FilesSession
     */
    private function registerFileSession():FilesSession
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        /** @var IApp $app */
        $app = $this->di->getShared('app');
        $uniqueId = $app->getAppId() . '_sess';
        $options = [
            'uniqueId' => $uniqueId
        ];
        return new FilesSession($options);
    }

    /**
     * @return LibmemcachedSession
     */
    private function registerLibmemcachedSession():LibmemcachedSession
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        /** @var IApp $app */
        $app = $this->di->getShared('app');
        $prefixKey = $app->getAppId() . '_sess';
        $prefix = $app->getAppId() . '_sess';
        $lifetime = (int)$config->get('session.memcached.lifetime', 3600);
        $options = [
            'servers' => $config->get('session.memcached.servers'),
            'client' => [
                \Memcached::OPT_HASH => \Memcached::HASH_MD5,
                \Memcached::OPT_PREFIX_KEY => $prefixKey,
            ],
            'lifetime' => $lifetime,
            'prefix' => $prefix
        ];
        return new LibmemcachedSession($options);
    }

    /**
     * @return MemcacheSession
     */
    private function registerMemcacheSession():MemcacheSession
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        /** @var IApp $app */
        $app = $this->di->getShared('app');
        $uniqueId = $app->getAppId() . '_sess';
        $prefix = $app->getAppId() . '_sess';
        $lifetime = (int)$config->get('session.memcache.lifetime', 3600);
        $persistent = (bool)$config->get('session.memcache.persistent', true);
        $host = $config->get('session.memcache.host', '127.0.0.1');
        $port = $config->get('session.memcache.port', 11300);

        if (!Validator::port($port)) {
            throw new \InvalidArgumentException(
                sprintf('invalid memcache port: %s', $port)
            );
        }

        $options = [
            'uniqueId' => $uniqueId,
            'host' => $host,
            'port' => (int)$port,
            'persistent' => $persistent,
            'lifetime' => $lifetime,
            'prefix' => $prefix
        ];
        return new MemcacheSession($options);
    }

    /**
     * @return RedisSession
     */
    private function registerRedisSession():RedisSession
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        /** @var IApp $app */
        $app = $this->di->getShared('app');
        $uniqueId = $app->getAppId() . '_sess';
        $lifetime = (int)$config->get('session.redis.lifetime', 3600);
        $prefix = $app->getAppId() . '_sess';
        $persistent = (bool)$config->get('session.redis.persistent', false);
        $index = $config->get('session.redis.index', 1);
        $host = $config->get('session.redis.host', '127.0.0.1');
        $port = $config->get('session.redis.port', 6379);
        if (!Validator::port($port)) {
            throw new \InvalidArgumentException(
                sprintf('invalid redis port: %s', $port)
            );
        }
        $options = [
            'uniqueId' => $uniqueId,
            'host' => $host,
            'port' => $port,
            'auth' => $config->get('session.redis.auth'),
            'persistent' => $persistent,
            'lifetime' => $lifetime,
            'prefix' => $prefix,
            'index' => (int)$index
        ];
        return new RedisSession($options);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Session';
    }
}