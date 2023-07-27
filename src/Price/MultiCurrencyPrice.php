<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

use Nette\SmartObject;

final class MultiCurrencyPrice
{
    use SmartObject;

    /** @var Price[] */
    private array $prices = [];

    /**
     * @param Price[]|null $prices
     */
    public function __construct(?array $prices = [])
    {
        foreach ($prices as $price) {
            $this->prices[$price->getCurrency()->value] = $price;
        }
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

    /**
     * @return Price[]
     */
    public function getPrices(): array
    {
        return $this->prices;
    }

    public function getPrice(Currency $currency): Price
    {
        if (!isset($this->prices[$currency->value])) {
            throw new \OutOfRangeException(sprintf(_('Price for currency "%s" does not exists'), $currency->value));
        }
        return $this->prices[$currency->value];
    }

    public function setPrice(Price $price): void
    {
        if (!isset($this->prices[$price->getCurrency()->value])) {
            throw new \OutOfRangeException(
                sprintf(_('Price for the currency "%s" does not exists'), $price->getCurrency()->value)
            );
        }
        $this->prices[$price->getCurrency()->value] = $price;
    }

    public function immutableAddPrice(Price $price): self
    {
        return new self([...$this->prices, $price]);
    }

    public function add(self $multiPrice): void
    {
        foreach ($this->prices as $key => $price) {
            $this->prices[$key]->add($multiPrice->{$key});
        }
    }

    public function __get(string $name): ?Price
    {
        return $this->getPrice(Currency::from($name));
    }

    public function __set(string $name, Price $value): void
    {
        $name = strtoupper($name);
        if ($value->getCurrency()->value !== $name) {
            throw new \LogicException(sprintf(_('Currency "%s" does not match'), $name));
        }
        $this->setPrice($value);
    }

    public function __toString(): string
    {
        return join('/', array_map(fn($price) => $price->__toString(), $this->prices));
    }

    public function __serialize(): array
    {
        $data = [];
        foreach ($this->prices as $key => $price) {
            $data[$key] = $price->__serialize();
        }
        return $data;
    }
}
