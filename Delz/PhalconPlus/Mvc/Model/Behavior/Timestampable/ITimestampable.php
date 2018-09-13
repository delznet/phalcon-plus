<?php

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Timestampable;

/**
 * 某个数据模型需要有创建时间和更新时间可实现本接口
 *
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Timestampable
 */
interface ITimestampable
{
    /**
     * 返回创建时间
     *
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * 返回最近修改时间
     *
     * @return mixed
     */
    public function getUpdatedAt();

    /**
     * 设置创建时间
     *
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt = null);

    /**
     * 设置最近修改时间
     *
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt = null);
}