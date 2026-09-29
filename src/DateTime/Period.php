<?php

declare(strict_types=1);

namespace Fykosak\Utils\DateTime;

use Nette\InvalidStateException;

readonly class Period
{
    public function __construct(
        public ?\DateTimeInterface $begin,
        public ?\DateTimeInterface $end,
    ) {
        if (is_null($this->begin) && is_null($this->end)) {
            throw new InvalidStateException();
        }
        if ($this->begin > $this->end) {
            throw new \LogicException();
        }
    }

    public function isBefore(?\DateTimeInterface $dateTime = null): bool
    {
        if (isset($this->begin)) {
            return $this->begin > ($dateTime ?? new \DateTimeImmutable());
        }
        return false;
    }

    public function isAfter(?\DateTimeInterface $dateTime = null): bool
    {
        if (isset($this->end)) {
            return $this->end < ($dateTime ?? new \DateTimeImmutable());
        }
        return false;
    }

    public function isOnGoing(?\DateTimeInterface $dateTime = null): bool
    {
        return !$this->isBefore($dateTime) && !$this->isAfter($dateTime);
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
        return Phase::OnGoing;
    }

    public function duration(): \DateInterval
    {
        if (is_null($this->begin) || is_null($this->end)) {
            throw new \LogicException();
        }
        return $this->end->diff($this->begin);
    }
}
