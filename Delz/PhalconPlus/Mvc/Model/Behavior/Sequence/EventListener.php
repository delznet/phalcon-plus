<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Sequence;

use Delz\PhalconPlus\Event\EventListener as PhalconEventListener;
use Delz\PhalconPlus\Mvc\Model;
use Phalcon\Events\Event;

/**
 * Class EventListener
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Sequence
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
        if ($model instanceof ISequenceSubject) {
            $type = $model->getSequenceType();
            //查找服务
            $generatorName = $this->getDi()->get('config')->get('model.sequence.' . $type);
            if (!$generatorName) {
                throw new NonExistingGeneratorException($generatorName);
            }

            /** @var IGenerator $generator */
            $generator = $this->getDi()->get($generatorName);

            $model->setNumber($generator->generate($model));
        }
    }
}