<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

use Nette\NotImplementedException;

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
        $number = number_format(
            $amount,
            2,
            localeconv()['decimal_point'] ?: '.',
            localeconv()['thousands_sep'] ?: ''
        );
        return $number
            . "\u{205F}"
            . $this->getLabel();
    }
}
