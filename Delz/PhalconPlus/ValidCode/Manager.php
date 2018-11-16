<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\ValidCode;

use Phalcon\Cache\BackendInterface as ICache;
use Delz\PhalconPlus\Util\Str;

/**
 * 验证码管理类
 *
 * 包括验证码创建、检查等功能
 *
 * @package Delz\PhalconPlus\ValidCode
 */
class Manager
{
    /**
     * 保存验证码的缓存服务
     *
     * @var ICache
     */
    protected $cache;

    /**
     * 构造方法
     *
     * @param ICache $cache
     */
    public function __construct(ICache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * 创建验证码
     *
     * @param string $namespace 命名空间，具体说明见ValidCode类
     * @param string $recipient 验证码接收者，具体说明见ValidCode类
     * @param int $expireIn 有效时间，单位为秒
     * @param int $length 验证码长度
     * @param string $type 验证码类型 参考Delz\Common\Util\Str:random
     * @return string 验证码
     * @throws \Exception
     */
    public function create($namespace, $recipient, $expireIn = 300, $length = 6, $type = 'numeric')
    {
        $validCode = new ValidCode();
        $validCode->setNamespace($namespace);
        $validCode->setRecipient($recipient);
        $now = new \DateTime();
        $expiredAt = $now->add(new \DateInterval('PT' . $expireIn . 'S'));
        $validCode->setExpiredAt($expiredAt);
        $code = Str::random($length, $type);
        $validCode->setCode($code);
        $cacheKey = $this->getCacheKey($namespace, $recipient);
        $this->cache->save($cacheKey, $validCode, $expireIn);
        return $code;
    }

    /**
     * 检查验证码是否正确
     *
     * 验证成功后，删除缓存中保存的验证码
     *
     * @param string $code 需要检查的验证码
     * @param string $namespace 命名空间，具体说明见ValidCode类
     * @param string $recipient 验证码接收者，具体说明见ValidCode类
     * @return bool true为正确  false为错误
     */
    public function check($code, $namespace, $recipient)
    {
        $cacheKey = $this->getCacheKey($namespace, $recipient);
        /** @var ValidCode $validCode */
        $validCode = $this->cache->get($cacheKey);
        if (empty($validCode) || $validCode->isExpired() || $validCode->getCode() != $code) {
            return false;
        }
        //验证成功后删除缓存中保存的验证码
        $this->cache->delete($cacheKey);
        return true;
    }

    /**
     * 根据$namespace和$recipient生成缓存主键
     *
     * @param string $namespace 命名空间，具体说明见ValidCode类
     * @param string $recipient 验证码接收者，具体说明见ValidCode类
     * @return string 缓存主键
     */
    private function getCacheKey($namespace, $recipient)
    {
        return $namespace . '_' . $recipient;
    }

}