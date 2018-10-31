<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Sequence;

use Delz\PhalconPlus\ServiceProvider\Provider;

/**
 * Class TimeBasedGeneratorServiceProvider
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Sequence
 */
class TimeBasedGeneratorServiceProvider extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'timeBasedNumberGenerator';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $self = $this;
        $this->di->setShared(
            $this->serviceName,
            function () use ($self) {
                $cacheRepo = $self->di->get('cacheSequenceRepository');
                return new TimeBasedGenerator($cacheRepo);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '简单number生成服务';
    }
}