<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Sequence;

use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\ServiceProvider\Provider;

/**
 * Class CacheSequenceRepositoryServiceProvider
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Sequence
 */
class CacheSequenceRepositoryServiceProvider extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'cacheSequenceRepository';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $self = $this;
        $this->di->setShared(
            $this->serviceName,
            function () use ($self) {
                /** @var IConfig $config */
                $config = $self->di->getShared('config');
                $sequenceCacheServiceName = $config->get('model.sequence.cache');
                if (!$sequenceCacheServiceName) {
                    throw new SequenceCacheNotSetException();
                }
                $cache = $self->di->get($sequenceCacheServiceName);

                return new CacheSequenceRepository($cache);
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