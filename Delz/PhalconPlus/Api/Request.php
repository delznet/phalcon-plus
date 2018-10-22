<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Api;

use Phalcon\Validation\ValidatorInterface;
use Phalcon\Validation;

/**
 * 接口请求数据模型
 *
 * @package Delz\PhalconPlus\Api
 */
abstract class Request implements IRequest
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var ValidatorInterface
     */
    protected $validation;

    /**
     * 错误信息
     *
     * @var string
     */
    protected $messages;

    /**
     * {@inheritdoc}
     */
    public function __construct($data)
    {
        $this->validation = new Validation();
        $this->initialize();
        $this->parse($data);
    }

    /**
     * 初始化
     */
    abstract protected function initialize();

    /**
     * {@inheritdoc}
     */
    public function validate(): bool
    {
        $this->messages = $this->validation->validate($this->getData());
        return count($this->messages) > 0 ? false : true;
    }

    /**
     * @throws InvalidRequestDataException
     */
    public function onValidateFail()
    {
        throw new InvalidRequestDataException($this->messages[0]);
    }


    /**
     * 添加属性并设置相应验证器
     *
     * @param string $field
     * @param ValidatorInterface $validator
     * @return self
     */
    protected function add(string $field, ValidatorInterface $validator)
    {
        $this->data[$field] = null;
        $this->validation->add($field, $validator);
        return $this;
    }

    /**
     *
     * 解析外部数据
     *
     * @param mixed $data
     * @param string $type
     */
    protected function parse($data, string $type = "array")
    {
        $type = strtolower($type);
        if (!in_array($type, ['array', 'json'])) {
            throw new \InvalidArgumentException(
                sprintf('Parse type only support array or json, %s given.', $type)
            );
        }
        if ($type == 'json') {
            $data = json_decode($data, true);
        }
        foreach ($data as $k => $v) {
            if (isset($this->data[$k])) {
                $this->data[$k] = $v;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

}