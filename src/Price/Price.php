<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

use Nette\SmartObject;
use Nette\Utils\Html;

final class Price
{
    use SmartObject;

    private Currency $currency;
    private float $amount;

    public function __construct(Currency $currency, ?float $amount = null)
    {
        $this->amount = $amount ?? 0;
        $this->currency = $currency;
    }

    /**
     * @throws \LogicException
     */
    public function add(Price $price): void
    {
        if ($this->currency->value !== $price->getCurrency()->value) {
            throw new \LogicException('Currencies are not a same');
        }
        $this->amount += $price->getAmount();
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function addAmount(float $amount): void
    {
        $this->amount += $amount;
    }

    public function format(): Html
    {
        return $this->currency->format($this->amount);
    }

    public function __toString(): string
    {
        return $this->format()->render();
    }

    public function __serialize(): array
    {
        return [
            'currency' => $this->currency->value,
            'amount' => $this->amount,
        ];
    }
}
