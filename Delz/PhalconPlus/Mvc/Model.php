<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Mvc;

use Phalcon\Mvc\Model as PhalconModel;

/**
 * 模型
 *
 * @package Delz\PhalconPlus\Mvc
 */
abstract class Model extends PhalconModel
{
    /**
     * 将setSource设为public
     *
     * 可以让外部事件修改表名
     *
     * @param string $source
     */
    public function setSource($source)
    {
        parent::setSource($source);
    }

    /**
     * 获取对象主键
     *
     * @return mixed
     */
    abstract function getId();


}