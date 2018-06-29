<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\Exception\ClassNotFoundException;
use Delz\PhalconPlus\ServiceProvider\Provider;
use Phalcon\Filter as PhalconFilter;
use Delz\PhalconPlus\Config\IConfig;
use Phalcon\Filter\UserFilterInterface;

/**
 * 过滤器服务
 *
 * 内置过滤器：
 *
 * string    去除标签和HTML实体,包括单双引号
 * email    删掉除字母、数字和 !#$%&*+-/=?^_`{|}~@.[] 外的全部字符
 * int    删掉除R数字、加号、减号外的全部字符
 * float    删掉除数字、点号和加号、减号外的全部字符
 * alphanum    删掉除[a-zA-Z0-9]外的全部字符
 * striptags    调用 strip_tags 方法
 * trim    调用 trim 方法
 * lower    调用 strtolower 方法
 * upper    调用 strtoupper 方法
 *
 * 用户自定义过滤器在配置文件添加filters节点，如下
 *
 * [filters]
 * filter_name="App\Filter\SampleFilter"
 *
 * filter_name为过滤器名称
 * App\Filter\SampleFilter为过滤器类名
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Filter extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'filter';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $self = $this;
        $this->di->setShared(
            $this->serviceName,
            function () use ($self) {
                /** @var IConfig $config */
                $config = $this->di->getShared('config');
                $filter = new PhalconFilter();
                //加载自定义filter
                $userFilters = $config->get('filters');
                if ($userFilters && is_array($userFilters)) {
                    foreach ($userFilters as $filterName => $userFilterClass) {
                        $filter->add($filterName, function ($value) use ($userFilterClass) {
                            if (!class_exists($userFilterClass)) {
                                throw new ClassNotFoundException($userFilterClass);
                            }
                            $filterObj = new $userFilterClass();
                            if (!($filterObj instanceof UserFilterInterface)) {
                                throw new \RuntimeException(
                                    sprintf('class %s should be instance of Phalcon\Filter\UserFilterInterface', $userFilterClass)
                                );
                            }
                            $filterObj->filter($value);
                        });
                    }
                }
                return $filter;
            }
        );
    }
}