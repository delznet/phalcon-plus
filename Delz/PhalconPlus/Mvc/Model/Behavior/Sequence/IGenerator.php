<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Sequence;

/**
 * Interface IGenerator
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Sequence
 */
interface IGenerator
{
    /**
     * @param ISequenceSubject $subject
     * @return string
     */
    public function generate(ISequenceSubject $subject);
}