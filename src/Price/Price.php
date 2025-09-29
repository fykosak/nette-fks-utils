<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

final readonly class Price
{
    public function __construct(
        public Currency $currency,
        public float $amount = 0.0
    ) {
    }

    /**
     * @throws \LogicException
     */
    public function add(Price|float $price): self
    {
        if ($price instanceof Price) {
            if ($this->currency !== $price->currency) {
                throw new \LogicException('Currencies are not a same');
            }
            return new self($this->currency, $this->amount + $price->amount);
        }
        return new self($this->currency, $this->amount + $price);
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
