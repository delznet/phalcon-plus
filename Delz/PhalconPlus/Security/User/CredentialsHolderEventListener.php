<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Security\User;

use Delz\PhalconPlus\Event\EventListener;
use Phalcon\Events\Event;
use Delz\PhalconPlus\Mvc\Model;
use Delz\PhalconPlus\Util\Str;

/**
 * @package Delz\PhalconPlus\Security\User
 */
class CredentialsHolderEventListener extends EventListener
{
    /**
     * 监听model:beforeValidationOnCreate事件
     *
     * @param Event $event
     * @param Model $model
     */
    public function beforeValidationOnCreate(Event $event, Model $model)
    {
        if ($model instanceof ICredentialsHolder) {
            $this->createPassword($model);
        }
    }

    /**
     * 监听model:beforeValidationOnUpdate事件
     *
     * @param Event $event
     * @param Model $model
     */
    public function beforeValidationOnUpdate(Event $event, Model $model)
    {
        if ($model instanceof ICredentialsHolder && $model->getPlainPassword()) {
            $this->createPassword($model);
        }
    }

    /**
     * @param ICredentialsHolder $model
     */
    protected function createPassword(ICredentialsHolder $model)
    {
        $salt = Str::random();
        $model->setSalt($salt);
        $password = md5($model->getPlainPassword() . $salt);
        $model->setPassword($password);
        $model->eraseCredentials();
    }
}