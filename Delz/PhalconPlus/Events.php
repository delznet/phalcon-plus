<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus;

/**
 * 系统事件
 *
 * @package Delz\PhalconPlus
 */
final class Events
{
    /**
     * 当应用处理它首个请求时被执行
     */
    const APPLICATION_BOOT = 'application:boot';
    /**
     * 注册一个会在php中止时执行的事件，实现了php函数register_shutdown_function的功能
     */
    const APPLICATION_TERMINATE = 'application:terminate';
    /**
     * 捕捉应用异常事件
     */
    const APPLICATION_EXCEPTION = 'application:exception';
    /**
     * 在执行分发环前
     */
    const APPLICATION_BEFORE_HANDLE_REQUEST = 'application:beforeHandleRequest';
    /**
     * 在执行分发环后
     */
    const APPLICATION_AFTER_HANDLE_REQUEST = 'application:afterHandleRequest';
    const DISPATCH_BEFORE_DISPATCH_LOOP = 'dispatch:beforeDispatchLoop';
    const DISPATCH_BEFORE_DISPATCH = 'dispatch:beforeDispatch';
    const DISPATCH_BEFORE_EXECUTE_ROUTE = 'dispatch:beforeExecuteRoute';
    const DISPATCH_AFTER_INITIALIZE = 'dispatch:afterInitialize';
    const DISPATCH_AFTER_BINDING = 'dispatch:afterBinding';
    const DISPATCH_AFTER_EXECUTE_ROUTE = 'dispatch:afterExecuteRoute';
    const DISPATCH_AFTER_DISPATCH = 'dispatch:afterDispatch';
    const DISPATCH_AFTER_DISPATCH_LOOP = 'dispatch:afterDispatchLoop';
    const APPLICATION_BEFORE_SEND_RESPONSE = 'application:beforeSendResponse';
    const APPLICATION_VIEW_RENDER = 'application:viewRender';
    /**
     * 模型执行方法initialize后触发，可stop
     */
    const MODELSMANAGER_AFTER_INITIALIZE = 'modelsManager:afterInitialize';
    /**
     * 数据保存到数据库之前触发，包括insert和update，可stop
     */
    const MODEL_PREPARE_SAVE = 'model:prepareSave';
    /**
     * 在数据验证之前触发，包括insert和update，可stop
     */
    const MODEL_BEFORE_VALIDATION = 'model:beforeValidation';
    /**
     * 在数据验证之前触发，仅insert，可stop
     */
    const MODEL_BEFORE_VALIDATION_ONCREATE = 'model:beforeValidationOnCreate';
    /**
     * 在数据验证之前触发，仅update，可stop
     */
    const MODEL_BEFORE_VALIDATION_ONUPDATE = 'model:beforeValidationOnUpdate';
    /**
     * 数据验证失败触发，可stop(实际上已经stop)
     */
    const MODEL_ON_VALIDATION_FAILS = 'model:onValidationFails';
    /**
     * 在数据验证之后触发，仅insert，可stop
     */
    const MODEL_AFTER_VALIDATION_ONCREATE = 'model:afterValidationOnCreate';
    /**
     * 在数据验证之后触发，仅 update，可stop
     */
    const MODEL_AFTER_VALIDATION_ONUPDATE = 'model:afterValidationOnUpdate';
    /**
     * 在数据验证之后触发，包括insert和update，可stop
     */
    const MODEL_AFTER_VALIDATION = 'model:afterValidation';
    /**
     * 在写入数据库前触发，仅insert，可stop
     */
    const MODEL_BEFORE_CREATE = 'model:beforeCreate';
    /**
     * 在写入数据库前触发，仅 update，可stop
     */
    const MODEL_BEFORE_UPDATE = 'model:beforeUpdate';
    /**
     * 在写入数据库前触发，包括insert和update，可stop
     */
    const MODEL_BEFORE_SAVE = 'model:beforeSave';
    /**
     * 在写入数据库触发，仅insert，不可stop
     */
    const MODEL_AFTER_CREATE = 'model:afterCreate';
    /**
     * 在写入数据库触发，仅 update，不可stop
     */
    const MODEL_AFTER_UPDATE = 'model:afterUpdate';
    /**
     * 在写入数据库触发，包括insert和update，不可stop
     */
    const MODEL_AFTER_SAVE = 'model:afterSave';
    /**
     * 渲染过程开始前触发，可stop
     */
    const VIEW_BEFORE_RENDER = 'view:beforeRender';
    /**
     * 渲染一个现有的视图之前触发，可stop
     */
    const VIEW_BEFORE_RENDER_VIEW = 'view:beforeRenderView';
    /**
     * 渲染一个现有的视图之后触发，不可stop
     */
    const VIEW_AFTER_RENDER_VIEW = 'view:afterRenderView';
    /**
     * 渲染过程完成后触发，不可stop
     */
    const VIEW_AFTER_RENDER = 'view:afterRender';
    /**
     * 视图不存在时触发，不可stop
     */
    const VIEW_NOT_FOUND_VIEW = 'view:notFoundView';
    /**
     * 当成功连接数据库之后触发,不可stop操作
     */
    const DB_AFTER_CONNECT = 'db:afterConnect';
    /**
     * 在发送SQL到数据库前触发，可stop操作
     */
    const DB_BEFORE_QUERY = 'db:beforeQuery';
    /**
     * 在发送SQL到数据库执行后触发,不可stop操作
     */
    const DB_AFTER_QUERY = 'db:afterQuery';
    /**
     * 在关闭一个暂存的数据库连接前触发,不可stop操作
     */
    const DB_BEFORE_DISCONNECT = 'db:beforeDisconnect';
    /**
     * 事务启动前触发,不可stop操作
     */
    const DB_BEGIN_TRANSACTION = 'db:beginTransaction';
    /**
     * 事务回滚前触发,不可stop操作
     */
    const DB_ROLLBACK_TRANSACTION = 'db:rollbackTransaction';
    /**
     * 事务提交前触发,不可stop操作
     */
    const DB_COMMIT_TRANSACTION = 'db:commitTransaction';

    private function __construct()
    {
    }

}