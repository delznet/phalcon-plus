<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Hprose;

use stdClass;
use Hprose\Reader;
use Hprose\BytesIO;
use Hprose\Tags;
use Phalcon\Di\InjectionAwareInterface;
use Phalcon\DiInterface;
use Hprose\Future;
use Delz\PhalconPlus\Config\IConfig;


/**
 * hprose http服务
 *
 * @package Delz\PhalconPlus\Hprose
 */
class Service extends \Hprose\Http\Service implements InjectionAwareInterface
{

    /**
     * @var DiInterface
     */
    protected $di;

    /**
     * 重写构造函数，加入服务容器注入
     *
     * @param DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        parent::__construct();
        $this->setDI($di);
    }


    /**
     * {@inheritdoc}
     */
    public function setDI(DiInterface $di)
    {
        $this->di = $di;
    }

    /**
     * {@inheritdoc}
     */
    public function getDI():DiInterface
    {
        return $this->di;
    }

    /**
     * 重写方法，加入配置rpc判断，如果配置文件存在，直接调用rpc service provider，然后注册
     *
     * @param BytesIO $stream
     * @param stdClass $context
     * @return Future
     * @throws \Exception
     */
    protected function doInvoke(BytesIO $stream, stdClass $context)
    {
        $results = array();
        $reader = new Reader($stream);
        do {
            $reader->reset();
            $name = $reader->readString();
            $alias = strtolower($name);
            if(!isset($this->calls[$alias])) {
                //获取config服务
                /** @var IConfig $configService */
                $configService = $this->di->get('config');
                $rpcServiceKey = 'rpc-services.' . $name;
                if ($configService->has($rpcServiceKey)) {
                    $rpcServiceProviderClass = $configService->get($rpcServiceKey);
                    if (class_exists($rpcServiceProviderClass)) {
                        $rpcServiceProvider = new $rpcServiceProviderClass($this->di, $this);
                        if ($rpcServiceProvider instanceof IProvider) {
                            $rpcServiceProvider->register();
                        }
                    }
                }
            }
            $cc = new stdClass();
            $cc->isMissingMethod = false;
            foreach ($context as $key => $value) {
                $cc->$key = $value;
            }
            $call = false;
            if (isset($this->calls[$alias])) {
                $call = $this->calls[$alias];
            } else if (isset($this->calls['*'])) {
                $call = $this->calls['*'];
                $cc->isMissingMethod = true;
            }
            if ($call) {
                foreach ($call as $key => $value) {
                    $cc->$key = $value;
                }
            }
            $args = array();
            $cc->byref = false;
            $tag = $stream->getc();
            if ($tag === Tags::TagList) {
                $reader->reset();
                $args = $reader->readListWithoutTag();
                $tag = $stream->getc();
                if ($tag === Tags::TagTrue) {
                    $cc->byref = true;
                    $arguments = array();
                    foreach ($args as &$value) {
                        $arguments[] = &$value;
                    }
                    $args = $arguments;
                    $tag = $stream->getc();
                }
            }
            if ($tag !== Tags::TagEnd && $tag !== Tags::TagCall) {
                $data = $stream->toString();
                throw new \Exception("Unknown tag: $tag\r\nwith following data: $data");
            }
            if ($call) {
                $results[] = $this->beforeInvoke($name, $args, $cc);
            } else {
                $results[] = $this->sendError(new \Exception("Can't find this function $name()."), $cc);
            }
        } while ($tag === Tags::TagCall);
        return Future\reduce($results, function ($stream, $result) {
            $stream->write($result);
            return $stream;
        }, new BytesIO())->then(function ($stream) {
            $stream->write(Tags::TagEnd);
            $data = $stream->toString();
            $stream->close();
            return $data;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function header($name, $value, $context)
    {
        $context->response->setHeader($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute($name, $context)
    {
        return $context->request->getServer($name);
    }

    /**
     * {@inheritdoc}
     */
    public function hasAttribute($name, $context)
    {
        return $context->request->hasServer($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function readRequest($context)
    {
        return $context->request->getRawBody();
    }

    /**
     * {@inheritdoc}
     */
    public function writeResponse($data, $context)
    {
        $context->response->setContent($data);
        $context->response->send();
    }

    /**
     * {@inheritdoc}
     */
    public function isGet($context)
    {
        return $context->request->isGet();
    }

    /**
     * {@inheritdoc}
     */
    public function isPost($context)
    {
        return $context->request->isPost();
    }

}