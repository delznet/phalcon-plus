<?php

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Timestampable;

/**
 * 实现了ITimestampable接口的trait
 *
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Timestampable
 */
trait TTimestampable
{
    /**
     * 创建时间
     *
     * @Column("column"="created_at",type="datetime",nullable=false)
     * @var mixed
     */
    public $createdAt;

    /**
     * 最新修改时间
     *
     * @Column("column"="updated_at",type="datetime",nullable=true)
     * @var mixed
     */
    public $updatedAt;

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;
    }
}