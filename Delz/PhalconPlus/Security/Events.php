<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Security;

/**
 * 安全事件
 *
 * @package Delz\PhalconPlus\Security
 */
class Events
{
    /**
     * 认证成功后事件
     */
    const AUTHENTICATE_SUCCESS = 'authenticate:success';

    /**
     * 认证失败:创建token失败
     */
    const AUTHENTICATE_FAIL_CREATE_TOKEN = 'authenticate:failCreateToken';

    /**
     * 认证失败:用户没有找到
     */
    const AUTHENTICATE_FAIL_USER_NOT_FOUND = 'authenticate:failUserNotFound';

    /**
     * 认证失败:用户没有激活
     */
    const AUTHENTICATE_FAIL_USER_DISABLED = 'authenticate:failUserDisabled';

    /**
     * 认证失败:令牌不对
     */
    const AUTHENTICATE_FAIL_BAD_CREDENTIALS = 'authenticate:failBadCredentials';
}