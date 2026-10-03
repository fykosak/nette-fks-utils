<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

final class MultiCurrencyPrice
{
    /**
     * @param array<value-of<Currency>,float> $prices
     */
    public function __construct(
        public array $prices = []
    ) {
    }

    /**
     * @param Currency[] $currencies
     * @return static
     */
    public static function createFromCurrencies(array $currencies): self
    {
        $data = [];
        foreach ($currencies as $currency) {
            $data[$currency->value] = 0.0;
        }
        return new self($data);
    }

    public function getPrice(Currency $currency): Price
    {
        return new Price($currency, $this->getAmount($currency));
    }

    /**
     * @return Price[]
     */
    public function getPrices(): array
    {
        $items = [];
        foreach ($this->prices as $key => $amount) {
            $items[] = new Price(Currency::from($key), $amount);
        }
        return $items;
    }

    public function getAmount(Currency $currency): float
    {
        if (isset($this->prices[$currency->value])) {
            return $this->prices[$currency->value];
        }
        throw new \OutOfRangeException(sprintf(_('Price for currency "%s" does not exists'), $currency->value));
    }

    public function add(self $multiPrice): self
    {
        foreach ($this->prices as $key => $price) {
            $currency = Currency::from($key);
            $this->prices[$key] = $this->getAmount($currency) + $multiPrice->getAmount($currency);
        }
        return $this;
    }

    public function cloneAdd(self $multiPrice): self
    {
        $data = [];
        foreach ($this->prices as $key => $price) {
            $currency = Currency::from($key);
            $data[$key] = $this->getAmount($currency) + $multiPrice->getAmount($currency);
        }
        return new self($data);
    }

    public function __serialize(): array
    {
        return $this->prices;
    }
}
