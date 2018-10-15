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
     * @var int
     */
    protected $id;

    /**
     * 返回自增Id
     *
     * @Primary
     * @Identity
     * @Column("column"="id","type"="integer",nullable=false)
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }
}