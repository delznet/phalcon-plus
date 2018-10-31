<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Sequence;

/**
 * Interface INumberSubject
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Sequence
 */
interface ISequenceSubject
{
    /**
     * @return null|string
     */
    public function getNumber():?string;

    /**
     * @param string $number
     * @return mixed
     */
    public function setNumber(string $number);

    /**
     * @return string
     */
    public function getSequenceType();
}