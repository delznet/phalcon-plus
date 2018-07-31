<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security\Authentication\Authenticator\Digest;

use Delz\PhalconPlus\Security\Authentication\Token as BaseToken;

/**
 * 摘要认证token
 *
 * 原理：
 *
 * 客户端发送如下参数到服务端请求验证，如果是http，则是在header部分发送如下信息：
 * - App-Id     //分配的id，具有唯一性
 * - Nonce      //随机数
 * - Timestamp  //unix时间戳
 * - Signature  //数据签名
 *
 * 服务端会给每个App-Id分配一个Secret，客户端发送这些数据的时候，服务端会进行验证。
 * 验证方法如下：
 * - 拼接字符串：Secret + Nonce + Timestamp
 * - 将拼接后的字符串取摘要信息 sha1(Secret + Nonce + Timestamp)
 * - 通过比较摘要信息是否与Signature是否一致判断是否授权
 * - Timestamp和当前时间比较，确定一个签名的失效期。
 *
 * @package Delz\PhalconPlus\Security\Authentication\Token
 */
class Token extends BaseToken
{
    /**
     * 应用id，用户唯一标记
     *
     * @var string
     */
    protected $appId;

    /**
     * 随机数
     *
     * @var string
     */
    protected $nonce;

    /**
     * unix时间戳
     *
     * @var int
     */
    protected $timestamp;

    /**
     * 数据签名
     *
     * @var string
     */
    protected $signature;

    /**
     * @param string $appId
     * @param string $nonce
     * @param int $timestamp
     * @param string $signature
     */
    public function __construct(string $appId, string $nonce, int $timestamp, string $signature)
    {
        $this->appId = $appId;
        $this->nonce = $nonce;
        $this->timestamp = $timestamp;
        $this->signature = $signature;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier():string
    {
        return $this->appId;
    }

}