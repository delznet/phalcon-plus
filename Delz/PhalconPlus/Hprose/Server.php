<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Hprose;

use Phalcon\Http\Request;
use Phalcon\Http\Response;

/**
 * hprose http服务
 *
 * @package Delz\PhalconPlus\Hprose
 */
class Server extends Service
{
    /**
     * 启动服务
     */
    public function start()
    {
        /** @var Request $request */
        $request = $this->di->get('request');
        /** @var Response $response */
        $response = $this->di->get('response');
        $this->handle($request, $response);
    }

}