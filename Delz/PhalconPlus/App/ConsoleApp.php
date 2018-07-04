<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\App;

use Delz\PhalconPlus\Command\AssetCommand;
use Delz\PhalconPlus\Command\RoutesCommand;
use Delz\PhalconPlus\Command\ServicesCommand;
use Delz\PhalconPlus\Config\IConfig;
use Delz\Console\Command\Pool;
use Delz\Console\Contract\ICommand;
use Delz\Console\Input\ArgvInput;
use Delz\Console\Output\Stream;

/**
 * 控制台应用
 *
 * @package Delz\PhalconPlus\App
 */
class ConsoleApp extends App
{
    /**
     * {@inheritdoc}
     */
    public function __construct(string $appId = null)
    {
        //只能在命令行下使用
        if (php_sapi_name() !== 'cli') {
            throw new \RuntimeException("can not run this script outside of cli");
        }

        parent::__construct($appId);
        $this->initCommandPoolService();
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $commandOutput = new Stream();
        $commandInput = new ArgvInput();
        //第一个参数为命令名称
        $commandName = $commandInput->getFirstArgument();
        if (is_null($commandName)) {
            //显示所有命令
            $commandOutput->writeln("usage: " . $commandInput->getName() . "\t[command] [<args>]");
            $commandOutput->writeln("Command list:");
            foreach ($this->di->get("commandPool")->all() as $k => $v) {
                $commandOutput->writeln("<comment>$k</comment>\t" . $v->getDescription());
            }
        } else {
            if (!$this->di->get("commandPool")->has($commandName)) {
                $commandOutput->writeln("<error>command: " . $commandName . " not exist</error>");
            } else {
                /** @var ICommand $command */
                $command = $this->di->get("commandPool")->get($commandName);
                try {
                    $command->run($commandInput, $commandOutput);
                } catch (\Exception $e) {
                    $commandOutput->writeln('<error>' . $e->getMessage() . '</error>');
                }

            }
        }
    }

    /**
     * 获取默认命令
     *
     * @return array
     */
    protected function getDefaultCommands()
    {
        return [
            new RoutesCommand(),
            new ServicesCommand(),
            new AssetCommand()
        ];
    }

    /**
     * 初始化命令容器服务
     */
    protected function initCommandPoolService()
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        $self = $this;
        $this->di->setShared(
            "commandPool",
            function () use ($config, $self) {
                $pool = new Pool();
                //加入默认命令
                foreach ($self->getDefaultCommands() as $command) {
                    $pool->add($command);
                }
                $commands = $config->get("commands");
                if (is_array($commands) && count($commands) > 0) {
                    foreach ($commands as $command) {
                        $pool->add(new $command());
                    }
                }
                return $pool;
            }
        );
    }


}