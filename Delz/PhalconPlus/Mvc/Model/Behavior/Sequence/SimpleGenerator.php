<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Mvc\Model\Behavior\Sequence;

/**
 * Class SimpleGenerator
 * @package Delz\PhalconPlus\Mvc\Model\Behavior\Sequence
 */
class SimpleGenerator implements IGenerator
{
    /**
     * @var ISubjectRepository
     */
    protected $subjectRepository;

    /**
     * SimpleGenerator constructor.
     * @param ISubjectRepository $subjectRepository
     */
    public function __construct(ISubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(ISequenceSubject $subject)
    {
        do {
            $number = date('ymd') . substr(time(),-5) .  str_pad(rand(0,99999),5,'0',STR_PAD_LEFT);
        } while ($this->subjectRepository->isNumberUsed($number));

        return $number;
    }


}