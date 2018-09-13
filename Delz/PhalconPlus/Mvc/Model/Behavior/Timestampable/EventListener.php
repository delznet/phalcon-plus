<?php

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Timestampable;

use Delz\PhalconPlus\Event\EventListener as PhalconEventListener;
use Delz\PhalconPlus\Mvc\Model;
use Phalcon\Events\Event;

/**
 * Timestampable EventListener
 *
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Timestampable
 */
class EventListener extends PhalconEventListener
{
    /**
     * 监听model:beforeValidationOnCreate事件
     *
     * @param Event $event
     * @param Model $model
     */
    public function beforeValidationOnCreate(Event $event, Model $model)
    {
        if($model instanceof ITimestampable) {
            $now = $this->getNow();
            if(!$model->getCreatedAt()) {
                $model->setCreatedAt($now);
            }
            if(!$model->getUpdatedAt()) {
                $model->setUpdatedAt($now);
            }
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
        if($model instanceof ITimestampable) {
            $now = $this->getNow();
            $model->setUpdatedAt($now);
        }
    }

    protected function getNow()
    {
        $config = $this->di->get('config');
        $timestampableFormat = $config->get('timestampable.format');
        switch($timestampableFormat) {
            case 'string':
                return date('Y-m-d H:i:s');
            case 'int':
                return time();
            default:
                return date('Y-m-d H:i:s');
        }
    }
}