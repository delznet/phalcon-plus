<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\App;

use Delz\PhalconPlus\Di;

/**
 * 应用接口类
 *
 * @package Delz\PhalconPlus\App
 */
interface IApp
{
    /**
     * 运行应用
     */
    public function run():void;

    /**
     * 获取容器
     *
     * @return Di
     */
    public function getDi():Di;

    /**
     * 获取应用Id
     *
     * @return string
     */
    public function getAppId():string;

    /**
     * 设置应用Id
     *
     * @param string $appId
     * @return IApp
     */
    public function setAppId(string $appId):IApp;

    /**
     * 获取当前模块名称
     *
     * @return string
     */
    public function getModule():string;

    /**
     * 设置模块名称
     *
     * @param string $moduleName 模块名称
     * @return IApp
     */
    public function setModule(string $moduleName):IApp;

    /**
     * 设置项目根目录
     *
     * @param string $dir
     * @return IApp
     */
    public function setRootDir(string $dir):IApp;

    /**
     * 获取项目根目录
     *
     * @return string
     */
    public function getRootDir():string;

    /**
     * 获取缓存目录
     *
     * @return string
     */
    public function getCacheDir():string;

    /**
     * 获取日志存储目录
     *
     * @return string
     */
    public function getLogDir():string;

    /**
     * 获取模板文件目录
     *
     * @return string
     */
    public function getViewDir():string;

    /**
     * 获取入口文件目录
     *
     * @return string
     */
    public function getEntryDir():string;

    /**
     * 获取版本
     *
     * @return string
     */
    public function getVersion():string;

}