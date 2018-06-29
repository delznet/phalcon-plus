<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Forms;
use Delz\PhalconPlus\Config\IConfig;
use Delz\PhalconPlus\IoC;
use Phalcon\Forms\Form;

/**
 * 表单管理器
 *
 * 增加从配置获取表单的逻辑
 *
 * @package Delz\PhalconPlus\Forms
 */
class Manager extends \Phalcon\Forms\Manager
{
    /**
     * {@inheritdoc}
     */
    public function create($name = null, $entity = null)
    {
        parent::create($name, $entity);
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        if(parent::has($name)) {
            return parent::get($name);
        }
        /** @var IConfig $config */
        $config = IoC::get('config');
        $formClass = $config->has('forms.' . $name);
        if(!$formClass || !class_exists($formClass)) {
            throw new \Exception("There is no form with name='" . $name . "'");
        }
        $form = new $formClass();
        if(!($form instanceof Form)) {
            throw new \InvalidArgumentException(
                sprintf('class %s not instance of Phalcon\Forms\Form', $formClass)
            );
        }
        $this->set($name, $form);
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        if(parent::has($name)) {
            return true;
        }
        /** @var IConfig $config */
        $config = IoC::get('config');
        //不做类是否存在的判断
        if($config->has('forms.' . $name)) {
            return true;
        }
        return false;
    }

}