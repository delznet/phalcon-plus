<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Command;

use Delz\Console\Contract\IInput;
use Delz\Console\Contract\IOutput;
use Delz\PhalconPlus\Config\Config;
use Phalcon\Assets\Manager;
use Phalcon\Assets\Collection;

/**
 * 资源文件管理命令
 *
 * @package Delz\PhalconPlus\Command
 */
class AssetCommand extends DiAwareCommand
{
    /**
     * @var Manager
     */
    protected $assetsManager;

    /**
     * @var string
     */
    protected $resourcePath;

    /**
     * @var string
     */
    protected $targetPath;

    /**
     * {@inheritdoc}
     */
    protected function execute(IInput $input, IOutput $output)
    {
        $this->assetsManager = $this->di->get('assets');
        $options = $this->assetsManager->getOptions();
        $this->resourcePath = $options['sourceBasePath'];
        $this->targetPath = $options['targetBasePath'];
        $configObj = new Config();
        $configObj->loadFile($options['configFilePath']);
        $config = $configObj->get();

        $tasks = [];
        if ($input->hasArgument('task')) {
            $taskName = $input->getArgument('task');
            if (!isset($config[$taskName])) {
                throw new \InvalidArgumentException(
                    sprintf("Invalid task: %s", $taskName)
                );
            }
            $tasks[$taskName] = $config[$taskName];
        } else {
            $tasks = $config;
        }

        foreach ($tasks as $k => $v) {
            if (!isset($v['type'])) {
                throw new \InvalidArgumentException(
                    sprintf('task %s with no type', $k)
                );
            }
            $type = $v['type'];
            switch ($type) {
                case 'js':
                    $this->handleJs($k, $v);
                    break;
                case 'css':
                    $this->handleCss($k, $v);
                    break;
                default:
                    throw new \InvalidArgumentException(
                        sprintf('invalid task type: %s', $k)
                    );
            }
            $output->writeln('Handle task: <comment>' . $k . '</comment> <info>Done.</info>');
        }

    }

    /**
     * 处理js
     *
     * @param string $task
     * @param array $options
     */
    protected function handleJs(string $task, array $options)
    {
        /** @var Collection $collection */
        $collection = $this->assetsManager->collection($task);

        if (isset($options['files'])) {
            foreach ($options['files'] as $file) {
                $collection->addJs($file, true);
            }
        }

        if (isset($options['join'])) {
            $collection->join((bool)$options['join']);
        }
        if (isset($options['filters'])) {
            foreach ($options['filters'] as $filter) {
                $filterObj = new $filter();
                $collection->addFilter($filterObj);
            }
        }
        if (isset($options['target'])) {
            $collection->setTargetPath($options['target']);
        }

        ob_start();
        $this->assetsManager->outputJs($task);
        ob_end_clean();
    }

    /**
     * 处理css
     *
     * @param string $task
     * @param array $options
     */
    protected function handleCss(string $task, array $options)
    {
        /** @var Collection $collection */
        $collection = $this->assetsManager->collection($task);

        if (isset($options['files'])) {
            foreach ($options['files'] as $file) {
                $collection->addCss($file, true);
            }
        }

        if (isset($options['join'])) {
            $collection->join((bool)$options['join']);
        }
        if (isset($options['filters'])) {
            foreach ($options['filters'] as $filter) {
                $filterObj = new $filter();
                $collection->addFilter($filterObj);
            }
        }
        if (isset($options['target'])) {
            $collection->setTargetPath($options['target']);
        }

        ob_start();
        $this->assetsManager->outputCss($task);
        ob_end_clean();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('asset')
            ->setDescription('资源文件管理');
    }
}