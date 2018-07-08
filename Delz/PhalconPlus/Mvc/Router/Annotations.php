<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Mvc\Router;

use Phalcon\Mvc\Router;

/**
 * 注解路由类
 *
 * 重写add，把路由写成全部小写
 *
 * @package Delz\PhalconPlus\Mvc\Router
 */
class Annotations extends \Phalcon\Mvc\Router\Annotations
{
    /**
     * {@inheritdoc}
     */
    public function add($pattern, $paths = null, $httpMethods = null, $position = Router::POSITION_LAST)
    {
        $pattern = strtolower($pattern);
        return parent::add($pattern, $paths, $httpMethods, $position);
    }

}