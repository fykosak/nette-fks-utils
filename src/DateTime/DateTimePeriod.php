<?php

declare(strict_types=1);

namespace Fykosak\Utils\DateTime;

class DateTimePeriod
{
    public function __construct(
        public readonly \DateTimeImmutable $begin,
        public readonly \DateTimeImmutable $end,
    ) {
        if ($this->begin->getTimestamp() > $this->end->getTimestamp()) {
            throw new \LogicException();
        }
    }

    public function isBefore(?\DateTimeInterface $dateTime = null): bool
    {
        $timeStamp = $dateTime ? $dateTime->getTimestamp() : time();
        return $this->begin->getTimestamp() > $timeStamp;
    }

    public function isAfter(?\DateTimeInterface $dateTime = null): bool
    {
        $timeStamp = $dateTime ? $dateTime->getTimestamp() : time();
        return $this->end->getTimestamp() < $timeStamp;
    }

    public function isOnGoing(?\DateTimeInterface $dateTime = null): bool
    {
        $timeStamp = $dateTime ? $dateTime->getTimestamp() : time();
        return $this->begin->getTimestamp() <= $timeStamp
            && $this->end->getTimestamp() >= $timeStamp;
    }

    public function is(Phase $period, ?\DateTimeInterface $dateTime = null): bool
    {
        return match ($period) {
            Phase::before => $this->isBefore($dateTime),
            Phase::after => $this->isAfter($dateTime),
            Phase::onGoing => $this->isOnGoing($dateTime)
        };
    }

    public function getPhase(?\DateTimeInterface $dateTime = null): Phase
    {
        if ($this->isBefore($dateTime)) {
            return Phase::before;
        }
        if ($this->isAfter($dateTime)) {
            return Phase::after;
        }
        if ($this->isOnGoing($dateTime)) {
            return Phase::onGoing;
        }
        throw new \LogicException();
    }

    public function duration(): \DateInterval
    {
        return $this->end->diff($this->begin);
    }
}
