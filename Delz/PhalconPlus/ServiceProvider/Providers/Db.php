<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\ServiceProvider\Providers;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\Util\Validator;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Db\Adapter\Pdo\Postgresql;

/**
 * 数据库服务
 *
 * 没有定义在容器中的默认服务名称 db，为了自由度高一点，可以在配置文件定义服务名称db，
 * 当然也可以成别的名称，达到可以建多个实例的目的。
 *
 * 本服务也可以做主从。
 *
 * @package Delz\PhalconPlus\ServiceProvider\Providers
 */
class Db extends Provider
{
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
                //获取使用的数据库适配器
                $adapterKey = strtolower($config->get($self->getName() . '.adapter', 'mysql'));
                switch ($adapterKey) {
                    case 'mysql':
                        $db = $self->createMysqlService();
                        break;
                    case 'postgresql':
                        $db = $self->createPostgresqlService();
                        break;
                    default:
                        throw new \InvalidArgumentException(
                            sprintf('Not support database adapter: %s', $adapterKey)
                        );
                }

                $db->setEventsManager($self->di->getShared('eventsManager'));

                return $db;

            }
        );
    }

    /**
     * Mysql服务
     *
     * @return Mysql
     */
    private function createMysqlService(): Mysql
    {
        $connection = new Mysql($this->resolveMysqlOrPostgresqlParameters());

        return $connection;
    }

    /**
     * Postgresql服务
     *
     * @return Postgresql
     */
    private function createPostgresqlService(): Postgresql
    {
        $connection = new Postgresql($this->resolveMysqlOrPostgresqlParameters());

        return $connection;
    }

    /**
     * 由于Mysql和Postgresql两者的参数是一样的，将参数检查合并在一个方法内
     *
     * @return array
     */
    private function resolveMysqlOrPostgresqlParameters()
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');

        //判断是否主从
        $isMaster = (bool)$config->get($this->getName() . '.is_master', true);
        if ($isMaster) {
            $normalParameters = [
                'host' => '',
                'dbname' => '',
                'username' => '',
                'password' => '',
                'port' => '',
                'charset' => 'UTF8'
            ];
            $parameters = array_intersect_key($config->get($this->getName()), $normalParameters);

        } else {
            $connections = $config->get($this->getName() . '.connections');
            if (!is_array($connections)) {
                throw new \InvalidArgumentException(
                    sprintf('Invalid %s parameters. It must be array.', $this->getName() . '.connections')
                );
            }
            $connections = array_shift($connections);
            $parameters = array_rand($connections);
        }

        if (!is_array($parameters)) {
            throw new \InvalidArgumentException(
                sprintf('invalid %s parameters.', $this->getName())
            );
        }
        if (!isset($parameters['host']) || !$parameters['host']) {
            throw new \InvalidArgumentException('host is not set.');
        }
        if (!isset($parameters['dbname']) || !$parameters['dbname']) {
            throw new \InvalidArgumentException('database name is not set.');
        }
        if (!isset($parameters['username']) || !$parameters['username']) {
            throw new \InvalidArgumentException('database name is not set.');
        }
        if (!isset($parameters['password']) || !$parameters['password']) {
            throw new \InvalidArgumentException('database name is not set.');
        }
        if (!isset($parameters['port']) || !$parameters['port']) {
            $parameters['port'] = 3306;
        }
        if (!Validator::port($parameters['port'])) {
            throw new \InvalidArgumentException(
                sprintf('invalid memcache port: %s', $parameters['port'])
            );
        }
        //设置编码
        if (!isset($parameters['charset'])) {
            $parameters['charset'] = 'UTF8';
        }
        $parameters['options'][\PDO::MYSQL_ATTR_INIT_COMMAND] = sprintf('SET NAMES \'%s\'', $parameters['charset']);
        unset($parameters['charset']);
        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '数据库';
    }
}