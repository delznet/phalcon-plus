<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\EventListener;

use Delz\PhalconPlus\Event\EventListener;
use Phalcon\Db\AdapterInterface as DbAdapterInterface;
use Phalcon\Events\Event;
use Delz\PhalconPlus\Config\IConfig;
use Phalcon\Logger\AdapterInterface as LoggerAdapterInterface;
USE Phalcon\Logger;

/**
 * 数据库日志监听类
 *
 * @package Delz\PhalconPlus\EventListener
 */
class DbLogListener extends EventListener
{
    /**
     * 监听Events::DB_BEFORE_QUERY事件
     *
     * @param Event $event
     * @param DbAdapterInterface $connection
     */
    public function beforeQuery(Event $event, DbAdapterInterface $connection)
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        //获取日志服务
        if (!$config->has('db.logger')) {
            return;
        }
        /** @var LoggerAdapterInterface $logger */
        $logger = $this->di->getShared($config->get('db.logger'));
        $sqlVariables = $connection->getSQLVariables();
        if (is_array($sqlVariables) && count($sqlVariables)) {
            $query = str_replace(array('%', '?'), array('%%', "'%s'"), $connection->getSQLStatement());
            $query = vsprintf($query, $sqlVariables);
            $logger->log(Logger::INFO, $query);
        } else {
            $logger->log(Logger::INFO, $connection->getSQLStatement());
        }


    }
}