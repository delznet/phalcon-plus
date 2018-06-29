<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\App;

use Delz\PhalconPlus\Hprose\Server;
use Delz\PhalconPlus\Exception\AppIdNullException;

/**
 * hprose http类型的rpc服务
 *
 * @package Delz\PhalconPlus\App
 */
class HproseHttpApp extends App
{
    /**
     * {@inheritdoc}
     */
    public function run():void
    {
        if (!$this->appId) {
            throw new AppIdNullException();
        }
        $server = new Server($this->getDi());
        $server->start();
    }
}