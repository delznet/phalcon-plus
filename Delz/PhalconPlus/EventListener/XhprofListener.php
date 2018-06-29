<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\EventListener;

use Delz\PhalconPlus\App\IApp;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\Event\EventListener;
use Phalcon\Application;
use Phalcon\Events\Event;
use Phalcon\Logger\AdapterInterface as LoggerAdapterInterface;

/**
 * Xhprof性能分析监听
 *
 * @package Delz\PhalconPlus\EventListener
 */
class XhprofListener extends EventListener
{
    /**
     * 是否开启了xhprofOn服务
     *
     * @var bool
     */
    protected $xhprofOn = false;

    /**
     * 应用启动事件
     *
     * @param Event $event
     * @param Application $app
     */
    public function boot(Event $event, Application $app)
    {
        /** @var IConfig $config */
        $config = $this->di->get('config');
        //获取概率xhprof
        $prob = (int)$config->get('xhprof.prob', 1);
        if ($prob <= 0 || $prob > 1) {
            $prob = 1;
        }
        $mtMax = intval(1 / $prob);
        //在一定概率下执行
        if (mt_rand(1, $mtMax) == 1) {
            xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
            $this->xhprofOn = true;
        }
    }

    /**
     * 应用执行结束事件
     *
     *
     *
     * @param Event $event
     * @param IApp $app
     */
    public function terminate(Event $event, IApp $app)
    {
        if ($this->xhprofOn) {
            /** @var IConfig $config */
            $config = $this->di->get('config');
            /** @var LoggerAdapterInterface $logger */
            $logger = $config->get('xhprof.logger');
            $data = xhprof_disable();
            $logger->log($data);
        }
    }
}