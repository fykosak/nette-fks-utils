<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

final readonly class MultiCurrencyPrice
{
    /** @var Price[] */
    public array $prices;

    /**
     * @param Price[] $prices
     */
    public function __construct(array $prices = [])
    {
        $this->prices = array_values($prices);
    }

    /**
     * @param Currency[] $currencies
     * @return static
     */
    public static function createFromCurrencies(array $currencies): self
    {
        $data = [];
        foreach ($currencies as $currency) {
            $data[] = new Price($currency);
        }
        return new self($data);
    }

    public function getPrice(Currency $currency): Price
    {
        foreach ($this->prices as $price) {
            if ($price->currency === $currency) {
                return $price;
            }
        }
        throw new \OutOfRangeException(sprintf(_('Price for currency "%s" does not exists'), $currency->value));
    }

    public function add(self $multiPrice): self
    {
        $data = [];
        foreach ($this->prices as $price) {
            $innerMultiPrice = $multiPrice->getPrice($price->currency);
            $data[] = $price->add($innerMultiPrice);
        }
        return new self($data);
    }

    public function __get(string $name): Price
    {
        return $this->getPrice(Currency::from(strtoupper($name)));
    }

    public function __toString(): string
    {
        return join('/', array_map(fn($price) => $price->__toString(), $this->prices));
    }

    public function __serialize(): array
    {
        $data = [];
        foreach ($this->prices as $price) {
            $data[$price->currency->value] = $price->__serialize();
        }
        return $data;
    }
}
