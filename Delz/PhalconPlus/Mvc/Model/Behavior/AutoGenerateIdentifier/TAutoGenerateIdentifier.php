<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\AutoGenerateIdentifier;

/**
 * 自增Id trait
 *
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\AutoGenerateIdentifier
 */
trait TAutoGenerateIdentifier
{
    /**
     * @Primary
     * @Identity
     * @Column("column"="id","type"="integer",nullable=false)
     * @var int
     */
    protected $id;

    /**
     * 返回自增Id
     *
     * @return int
     */
    public function getId()
    {
        return (int)$this->id;
    }
}