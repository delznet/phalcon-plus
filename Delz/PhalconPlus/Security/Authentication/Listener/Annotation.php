<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Security\Authentication\Listener;

use Delz\PhalconPlus\Event\EventListener;
use Delz\PhalconPlus\Security\Authentication\IAuthenticationListener;
use Delz\PhalconPlus\Security\Authentication\IAuthenticator;
use Delz\PhalconPlus\Security\Exception\AuthenticatorNotSetException;
use Delz\PhalconPlus\Security\Exception\AuthenticatorsNotFoundException;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Annotations\AdapterInterface as AnnotationsAdapterInterface;
use Phalcon\Annotations\Annotation as BaseAnnotation;

/**
 * 通过在控制器查找注释@Private关键字拦截dispatch:beforeDispatch事件
 *
 * @package Delz\PhalconPlus\Security\Authentication\Listener
 */
class Annotation extends EventListener implements IAuthenticationListener
{
    /**
     * {@inheritdoc}
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        /** @var AnnotationsAdapterInterface $annotationService */
        $annotationService = $this->di->get('annotations');
        $reflector = $annotationService->get($dispatcher->getControllerClass());
        $annotations = $reflector->getClassAnnotations();
        if ($annotations && $annotations->has('Private')) {
            /** @var BaseAnnotation $annotation */
            $annotation = $annotations->get('Private');
            if (!$annotation->hasArgument('handler')) {
                throw new AuthenticatorNotSetException();
            } else {
                $authenticators = $annotation->getArgument('handler');
            }
            if (!is_array($authenticators) || empty($authenticators)) {
                throw new AuthenticatorsNotFoundException();
            }
            foreach ($authenticators as $authenticatorName) {
                $authenticatorServiceName = $this->di->get('config')->get('security.authenticators.' . $authenticatorName);
                if(!$authenticatorServiceName) {
                    throw new AuthenticatorNotSetException();
                }
                /** @var IAuthenticator $authenticator */
                $authenticator = $this->di->get($authenticatorServiceName);
                $authenticator->handle();
            }
        }
    }

}