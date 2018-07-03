<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Command;

use Delz\Console\Contract\IInput;
use Delz\Console\Contract\IOutput;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\Exception\ClassNotFoundException;
use Delz\PhalconPlus\ServiceProvider\IProvider;

/**
 * 获取所有的服务
 *
 * @package Delz\PhalconPlus\Command
 */
class ServicesCommand extends DiAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function execute(IInput $input, IOutput $output)
    {
        $output->writeln('<info>config</info> = 配置');
        $output->writeln('<info>app</info> = 应用');
        /** @var IConfig $config */
        $config = $this->getDi()->get('config');
        $serviceProviders = $config->get('services');

        foreach ($serviceProviders as $k => $providerClass) {
            if (!class_exists($providerClass)) {
                throw new ClassNotFoundException($providerClass);
            }
            /** @var IProvider $provider */
            $provider = new $providerClass($this->di);

            $output->writeln('<info>' . $k . '</info> = ' . $provider->getDescription());
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('services')
            ->setDescription('获取所有的服务');
    }
}