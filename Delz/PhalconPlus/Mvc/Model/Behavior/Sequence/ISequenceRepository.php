<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Sequence;

/**
 * Interface ISequenceRepository
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Sequence
 */
interface ISequenceRepository
{
    /**
     * @param string $number
     * @return bool
     */
    public function isNumberUsed(string $number);
}