<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

/**
 * @phpstan-type TSerializedPrice array{currency:string,amount:float}
 */
final class Price
{
    public function __construct(
        public readonly Currency $currency,
        private float $amount = 0,
    ) {
    }

    /**
     * @throws \LogicException
     */
    public function add(Price $price): void
    {
        if ($this->currency !== $price->currency) {
            throw new \LogicException('Currencies are not a same');
        }
        $this->amount += $price->getAmount();
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function addAmount(float $amount): void
    {
        $this->amount += $amount;
    }

    public function __toString(): string
    {
        return $this->currency->format($this->amount);
    }

    /**
     * @phpstan-return TSerializedPrice
     */
    public function __serialize(): array
    {
        return [
            'currency' => $this->currency->value,
            'amount' => $this->amount,
        ];
    }
}
