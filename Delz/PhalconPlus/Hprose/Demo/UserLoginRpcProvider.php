<?php

namespace Delz\PhalconPlus\Hprose\Demo;

use Delz\PhalconPlus\Hprose\Provider;

/**
 * 用户登录rpc提供者
 *
 * @package Delz\PhalconPlus\Hprose\Demo
 */
class UserLoginRpcProvider extends Provider
{
    /**
     * rpc别名
     *
     * @var string
     */
    protected $name = 'login';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->server->addFunction(function ($username, $password) {
            /** @var UserManager $userManager */
            $userManager = $this->di->get('user-manager');
            return $userManager->login($username, $password);
        }, $this->name);
    }

}