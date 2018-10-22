<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Api;

/**
 * 接口返回结构
 *
 * @package Delz\PhalconPlus\Api
 */
class Response implements IResponse
{
    /**
     * 返回状态码，其中：0成功，其它为错误
     *
     * 参考规则：
     * 400开头非法请求
     * 500开头服务器错误
     *
     * @var int
     */
    protected $ret = 0;

    /**
     * 待返回给客户端的数据
     *
     * @var mixed
     */
    protected $data;

    /**
     * 错误返回信息
     *
     * @var string
     */
    protected $msg;

    /**
     * @return int
     */
    public function getRet(): int
    {
        return $this->ret;
    }

    /**
     * @param int $ret
     */
    public function setRet(int $ret)
    {
        $this->ret = $ret;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @param string $msg
     */
    public function setMsg(string $msg)
    {
        $this->msg = $msg;
    }

    /**
     * {@inheritdoc}
     */
    function jsonSerialize()
    {
        $data = [
            'ret' => $this->ret,
            'msg' => $this->msg,
        ];
        if ($this->ret == 0 && $this->data) {
            $data['data'] = $this->data;
        }
        return $data;
    }
}