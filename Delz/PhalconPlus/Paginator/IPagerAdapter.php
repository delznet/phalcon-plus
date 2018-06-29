<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Paginator;

/**
 * 分页数据适配器
 *
 * 可获取数据集数据以及记录数量
 *
 * @package Delz\PhalconPlus\Paginator
 */
interface IPagerAdapter
{
    /**
     * 返回数据集
     *
     * @param int $offset 数据集偏移量
     * @param int $limit 返回数据数量
     * @return mixed
     */
    public function getResults(int $offset, int $limit);

    /**
     * 获取记录条数
     *
     * @return int
     */
    public function count():int;
}