<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Mvc;

use Phalcon\Mvc\Model as PhalconModel;

/**
 * 模型
 *
 * @package Delz\PhalconPlus\Mvc
 */
class Model extends PhalconModel
{
    /**
     * 表名
     *
     * @var string
     */
    protected $tableName;

    /**
     * 初始化一些东西
     */
    public function initialize()
    {
        //如果设置了tableName，将tableName设置为表名
        if($this->tableName) {
            $this->setSource($this->tableName);
        }
    }


}