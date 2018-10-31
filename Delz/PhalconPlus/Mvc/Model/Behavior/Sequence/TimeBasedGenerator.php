<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Sequence;

/**
 * Class TimeBasedGenerator
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Sequence
 */
class TimeBasedGenerator implements IGenerator
{
    /**
     * @var ISequenceRepository
     */
    protected $sequenceRepository;

    /**
     * TimeBasedGenerator constructor.
     * @param ISequenceRepository $sequenceRepository
     */
    public function __construct(ISequenceRepository $sequenceRepository)
    {
        $this->sequenceRepository = $sequenceRepository;
    }

    /**
     * @param ISequenceSubject $subject
     * @return string
     */
    public function generate(ISequenceSubject $subject):string
    {
        do {
            $number = date('ymd') . substr(time(),-5) .  str_pad(rand(0,99999),5,'0',STR_PAD_LEFT);
        } while ($this->sequenceRepository->isNumberUsed($number));

        return $number;
    }

}