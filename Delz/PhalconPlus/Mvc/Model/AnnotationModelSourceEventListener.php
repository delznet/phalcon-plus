<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model;

use Delz\PhalconPlus\Event\EventListener;
use Phalcon\Events\Event;
use Phalcon\Mvc\Model\Manager as EventManager;
use Delz\PhalconPlus\Mvc\Model;
use Phalcon\Annotations\AdapterInterface as AnnotationsAdapterInterface;
use Phalcon\Annotations\Annotation as BaseAnnotation;

/**
 * 通过在model注释设置表名
 *
 * @package Delz\PhalconPlus\Mvc\Model
 */
class AnnotationModelSourceEventListener extends EventListener
{
    /**
     * @param Event $event
     * @param EventManager $em
     * @param Model $model
     */
    public function afterInitialize(Event $event, EventManager $em, Model $model)
    {
        $class = get_class($model);
        /** @var AnnotationsAdapterInterface $annotationService */
        $annotationService = $this->di->get('annotations');
        $reflector = $annotationService->get($class);
        $annotations = $reflector->getClassAnnotations();
        if ($annotations->has('Table')) {
            /** @var BaseAnnotation $annotation */
            $annotation = $annotations->get('Table');
            $model->setSource($annotation->getArgument(0));
        }
    }
}