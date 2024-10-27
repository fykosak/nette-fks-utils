<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

/**
 * something like enum :)
 */
enum Currency: string
{
    case EUR = 'EUR';
    case CZK = 'CZK';

    public function getLabel(): string
    {
        return match ($this) {
            self::EUR => '€',
            self::CZK => 'Kč',
        };
    }

    public function format(float $amount): string
    {
        return \sprintf('%1.2f %s', $amount, $this->getLabel());
    }
}
