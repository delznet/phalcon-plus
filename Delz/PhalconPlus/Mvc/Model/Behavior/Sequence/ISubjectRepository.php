<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Sequence;

/**
 * Interface ISubjectRepository
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Sequence
 */
interface ISubjectRepository
{
    /**
     * @param string $number
     * @return bool
     */
    public function isNumberUsed(string $number);
}