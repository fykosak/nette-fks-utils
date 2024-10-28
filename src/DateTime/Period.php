<?php

declare(strict_types=1);

namespace Fykosak\Utils\DateTime;

class Period
{
    public function __construct(
        public readonly \DateTimeInterface $begin,
        public readonly \DateTimeInterface $end,
    ) {
        if ($this->begin > $this->end) {
            throw new \LogicException();
        }
    }

    public function isBefore(?\DateTimeInterface $dateTime = null): bool
    {
        return $this->begin > ($dateTime ?? new \DateTimeImmutable());
    }

    public function isAfter(?\DateTimeInterface $dateTime = null): bool
    {
        return $this->end < ($dateTime ?? new \DateTimeImmutable());
    }

    public function isOnGoing(?\DateTimeInterface $dateTime = null): bool
    {
        return $this->begin <= ($dateTime ?? new \DateTimeImmutable())
            && $this->end >= ($dateTime ?? new \DateTimeImmutable());
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
