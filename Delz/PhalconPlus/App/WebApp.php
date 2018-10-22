<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\App;

use Delz\PhalconPlus\Events;
use Delz\PhalconPlus\Exception\AppIdNullException;
use Delz\PhalconPlus\Api\Response as ApiResponse;
use Delz\PhalconPlus\Mvc\Controller\JsonController;
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Application;

/**
 * web应用
 *
 * @package Delz\PhalconPlus\App
 */
class WebApp extends App
{
    /**
     *
     * @var Application
     */
    protected $application;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $appId)
    {
        //处理利用php内置web服务器的情况
        if (php_sapi_name() == 'cli-server') {
            $_GET['_url'] = preg_replace('#^' . preg_quote($_SERVER['SCRIPT_NAME']) . '#', '', $_SERVER['PHP_SELF']);
        }

        //解决网址大小写问题，将网址全部转化成小写
        if (isset($_GET['_url'])) {
            $_GET['_url'] = strtolower($_GET['_url']);
        }

        parent::__construct($appId);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (!$this->appId) {
            throw new AppIdNullException();
        }
        $ex = null;
        $response = null;
        try {
            /** @var Response|null $response */
            $response = $this->getApplication()->handle();
            /** @var Dispatcher $dispatcher */
            $dispatcher = $this->di->get('dispatcher');
            $activeController = $dispatcher->getActiveController();
            $controllerClass = $dispatcher->getControllerClass();
            $parentClass = get_parent_class($controllerClass);
            if ($parentClass == 'Delz\PhalconPlus\Mvc\Controller\JsonController'
                || ($activeController && $activeController instanceof JsonController)
            ) {
                $apiResult = new ApiResponse();
                $apiResult->setMsg('OK');
                $apiResult->setData($dispatcher->getReturnedValue());
                $response->setHeader('Access-Control-Allow-Origin', '*');
                $response->setHeader('Access-Control-Allow-Methods', 'POST');
                $response->setHeader('Access-Control-Allow-Headers', 'x-requested-with,content-type');
                $response->setJsonContent($apiResult);
            }
            $response->send();
        } catch (\Exception $e) {
            $this->di->get('eventsManager')->fire(Events::APPLICATION_EXCEPTION, $e);
        }
    }

    /**
     * @return Application
     */
    public function getApplication():Application
    {
        if ($this->application) {
            return $this->application;
        }
        $this->application = new Application();
        $this->application->setDI($this->di);
        $this->application->setEventsManager($this->di->get('eventsManager'));
        return $this->application;
    }
}