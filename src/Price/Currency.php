<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

/**
 * something like enum :)
 */
final class Currency
{
    public const EUR = 'eur';
    public const CZK = 'czk';

    public string $value;

    public function __construct(string $currency)
    {
        if (!in_array($currency, [self::EUR, self::CZK])) {
            throw new \ValueError();
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
        } catch (\Throwable$exception) {
            return null;
        }
    }

    public static function from(string $currency): self
    {
        return new self($currency);
    }

    /**
     * @throws UnsupportedCurrencyException
     */
    public function getLabel(): string
    {
        switch ($this->value) {
            case self::EUR:
                return '€';
            case self::CZK:
                return 'Kč';
            default:
                throw new UnsupportedCurrencyException($this);
        }
    }

    /**
     * @throws UnsupportedCurrencyException
     */
    public function format(float $amount): string
    {
        return \sprintf('%1.2f %s', $amount, $this->getLabel());
    }
}
