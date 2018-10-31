<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Sequence;

use Phalcon\Cache\BackendInterface as ICache;

/**
 * 利用缓存存储使用过的number，如果加上时间戳到秒的，缓存过时时间控制在30秒就可以了
 *
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Sequence
 */
class CacheSequenceRepository implements ISequenceRepository
{

    const __CACHE_PREFIX = '__SEQUENCE_NUMBER__';

    /**
     * @var ICache
     */
    protected $cache;

    /**
     * CacheSequenceRepository constructor.
     * @param ICache $cache
     */
    public function __construct(ICache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function isNumberUsed(string $number)
    {
        return $this->cache->exists($this->getCacheKey($number));
    }

    /**
     * @param $number
     * @return string
     */
    protected function getCacheKey(string $number): string
    {
        return self::__CACHE_PREFIX . $number;
    }

}