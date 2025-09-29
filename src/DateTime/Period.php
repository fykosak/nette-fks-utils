<?php

declare(strict_types=1);

namespace Fykosak\Utils\DateTime;

readonly class Period
{
    public function __construct(
        public \DateTimeInterface $begin,
        public \DateTimeInterface $end,
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
            Phase::Before => $this->isBefore($dateTime),
            Phase::After => $this->isAfter($dateTime),
            Phase::OnGoing => $this->isOnGoing($dateTime)
        };
    }

    public function getPhase(?\DateTimeInterface $dateTime = null): Phase
    {
        if ($this->isBefore($dateTime)) {
            return Phase::Before;
        }
        if ($this->isAfter($dateTime)) {
            return Phase::After;
        }
        if ($this->isOnGoing($dateTime)) {
            return Phase::OnGoing;
        }
        throw new \LogicException();
    }

    public function duration(): \DateInterval
    {
        return $this->end->diff($this->begin);
    }
}
