<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\EventListener;

use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\Event\EventListener;
use Phalcon\DiInterface;
use Delz\PhalconPlus\Db\Profiler;
use Phalcon\Events\Event;
use Phalcon\Db\AdapterInterface as DbAdapterInterface;
use Phalcon\Logger\AdapterInterface as LoggerAdapterInterface;

/**
 * 数据库性能分析监听
 *
 * @package Delz\PhalconPlus\EventListener
 */
class DbProfilerListener extends EventListener
{
    /**
     * @var Profiler
     */
    protected $profiler;

    /**
     * @param DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        parent::__construct($di);
        //获取日志服务
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        //获取日志服务
        if (!$config->has('db.profile.logger')) {
            throw new \RuntimeException('parameter "db.profile.logger" is not set.');
        }
        /** @var LoggerAdapterInterface $logger */
        $logger = $this->di->getShared($config->get('db.profile.logger'));
        $this->profiler = new Profiler($logger);
    }

    /**
     * 监听Events::DB_BEFORE_QUERY事件
     *
     * @param Event $event
     * @param DbAdapterInterface $connection
     */
    public function beforeQuery(Event $event, DbAdapterInterface $connection)
    {
        $this->profiler->startProfile(
            $connection->getSQLStatement(), $connection->getSQLVariables()
        );
    }

    /**
     * 监听Events::DB_AFTER_QUERY事件
     */
    public function afterQuery()
    {
        $this->profiler->stopProfile();
    }

}