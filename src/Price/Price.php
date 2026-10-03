<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

final class Price
{
    public function __construct(
        public readonly Currency $currency,
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
            $this->amount += $price->amount;

        } else {
            $this->amount += $price;
        }
        return $this;
    }

    /**
     * @throws \LogicException
     */
    public function cloneAdd(Price|float $price): self
    {
        if ($price instanceof Price) {
            if ($this->currency !== $price->currency) {
                throw new \LogicException('Currencies are not a same');
            }
            return new self($this->currency, $this->amount + $price->amount);
        }
        return new self($this->currency, $this->amount + $price);
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
