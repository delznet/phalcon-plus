<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Sequence;

use Delz\PhalconPlus\ServiceProvider\Provider;

/**
 * Class SimpleGeneratorServiceProvider
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Sequence
 */
class SimpleGeneratorServiceProvider extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'simpleNumberGenerator';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                return new SimpleGenerator();
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