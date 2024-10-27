<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

final class Price
{
    private float $amount;

    public function __construct(
        public readonly Currency $currency,
        ?float $amount = null
    ) {
        $this->amount = $amount ?? 0;
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
     * @phpstan-return array{currency:string,amount:float}
     */
    public function __serialize(): array
    {
        return [
            'currency' => $this->currency->value,
            'amount' => $this->amount,
        ];
    }
}
