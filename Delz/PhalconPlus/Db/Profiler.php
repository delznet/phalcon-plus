<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Db;

use Phalcon\Db\Profiler as DbProfiler;
use Phalcon\Db\Profiler\Item as Item;
use Phalcon\Logger\AdapterInterface as LoggerAdapterInterface;

/**
 * 数据库查询分析
 *
 * @package Delz\PhalconPlus\Db
 */
class Profiler extends DbProfiler
{
    /**
     * 日志服务
     *
     * @var LoggerAdapterInterface
     */
    protected $logger;

    /**
     * 日志内容
     *
     * @var string
     */
    protected $log;

    /**
     * @param LoggerAdapterInterface $logger
     */
    public function __construct(LoggerAdapterInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Item $profile
     */
    public function beforeStartProfile(Item $profile)
    {
        $sqlVariables = $profile->getSqlVariables();
        if (is_array($sqlVariables) && count($sqlVariables)) {
            $query = str_replace(array('%', '?'), array('%%', "'%s'"), $profile->getSqlStatement());
            $query = vsprintf($query, $sqlVariables);
            $this->log = sprintf("%s\t%f", $query, $profile->getInitialTime());
        } else {
            $this->log = sprintf("%s\t%f", $profile->getSqlStatement(), $profile->getInitialTime());
        }

    }

    /**
     * @param Item $profile
     */
    public function afterEndProfile(Item $profile)
    {
        $this->log .= sprintf("\t%f\t%f", $profile->getFinalTime(), $profile->getTotalElapsedSeconds());
        $this->logger->log($this->log);
    }
}