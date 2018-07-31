<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\EventListener;

use Delz\PhalconPlus\Event\EventListener;
use Phalcon\Events\Event;
use Delz\PhalconPlus\Mvc\ApiResult;
use Phalcon\Http\Response;

/**
 * 异常返回json
 *
 * 格式为Delz\PhalconPlus\Mvc\ApiResult
 *
 * @package Delz\PhalconPlus\EventListener
 */
class ApiExceptionListener extends EventListener
{
    /**
     * @param Event $event
     * @param \Exception $e
     * @param string $module
     * @throws $e
     */
    public function onException(Event $event, \Exception $e, string $module = '')
    {
        $apiResult = new ApiResult();
        $apiResult->setMsg($e->getMessage());
        $apiResult->setRet($e->getCode());
        $response = new Response();
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Methods', 'POST');
        $response->setHeader('Access-Control-Allow-Headers', 'x-requested-with,content-type');
        $response->setJsonContent($apiResult);
        $response->send();
        $event->stop();
    }
}