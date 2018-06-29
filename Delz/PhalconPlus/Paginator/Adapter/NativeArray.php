<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Paginator\Adapter;

use Delz\PhalconPlus\Paginator\IPagerAdapter;

/**
 * 分页数据适配器 － 数组
 *
 * @package Delz\PhalconPlus\Paginator\Adapter
 */
class NativeArray implements IPagerAdapter
{
    /**
     * 数据集数组
     *
     * @var array
     */
    protected $array = [];

    /**
     * 构造方法
     *
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        $this->array = $array;
    }

    /**
     * 获取数组
     *
     * @return array
     */
    public function getArray():array
    {
        return $this->array;
    }

    /**
     * {@inheritdoc}
     */
    public function getResults(int $offset, int $limit)
    {
        return array_slice($this->array, $offset, $limit);
    }

    /**
     * {@inheritdoc}
     */
    public function count():int
    {
        return count($this->array);
    }
}