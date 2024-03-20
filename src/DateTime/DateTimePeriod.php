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

    public function is(Period $period, ?\DateTimeInterface $dateTime = null): bool
    {
        return match ($period) {
            Period::before => $this->isBefore($dateTime),
            Period::after => $this->isAfter($dateTime),
            Period::onGoing => $this->isOnGoing($dateTime)
        };
    }

    public function getPeriod(?\DateTimeInterface $dateTime = null): Period
    {
        if ($this->isBefore($dateTime)) {
            return Period::before;
        }
        if ($this->isAfter($dateTime)) {
            return Period::after;
        }
        if ($this->isOnGoing($dateTime)) {
            return Period::onGoing;
        }
        throw new \LogicException();
    }

    public function duration(): \DateInterval
    {
        return $this->end->diff($this->begin);
    }
}
