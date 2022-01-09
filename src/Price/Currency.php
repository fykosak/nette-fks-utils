<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

use Nette\NotImplementedException;
use Nette\SmartObject;

/**
 * something like enum :)
 */
final class Currency
{
    use SmartObject;

    public const EUR = 'eur';
    public const CZK = 'czk';

    public string $value;

    /**
     * @throws NotImplementedException
     */
    public function __construct(string $currency)
    {
        if (!in_array($currency, [self::EUR, self::CZK])) {
            throw new NotImplementedException(sprintf(_('Currency "%s" is not supported'), $currency));
        }
        $this->value = $currency;
    }

    public static function cases(): array
    {
        return [new self(self::CZK), new self(self::EUR)];
    }

    public static function tryFrom(string $currency): ?self
    {
        try {
            return new self($currency);
        } catch (NotImplementedException $exception) {
            return null;
        }
    }

    /**
     * @throws NotImplementedException
     */
    public static function from(string $currency): self
    {
        return new self($currency);
    }

    public function getLabel(): string
    {
        switch ($this->value) {
            case self::EUR:
                return '€';
            case self::CZK:
                return 'Kč';
        }
        return '';
    }

    public function format(float $amount): string
    {
        return \sprintf('%1.2f %s', $amount, $this->getLabel());
    }
}
