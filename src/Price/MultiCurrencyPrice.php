<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

use Nette\SmartObject;

final class MultiCurrencyPrice
{
    use SmartObject;

    /** @var Price[] */
    private array $prices;

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

    public function __get(string $name): ?Price
    {
        if (!isset($this->prices[$name])) {
            throw new \OutOfRangeException(sprintf(_('Price for currency "%s" does not exists'), $name));
        }
        return $this->prices[$name];
    }

    public function __set(string $name, Price $value): void
    {
        if ($value->getCurrency()->value !== $name) {
            throw new \OutOfRangeException(sprintf(_('Currency "%s" does not match'), $name));
        }
        if (!isset($this->prices[$value->getCurrency()->value])) {
            throw new \OutOfRangeException(sprintf(_('Price for the currency "%s" does not exists'), $name));
        }
        $this->prices[$value->getCurrency()->value] = $value;
    }

    public function add(self $multiPrice): void
    {
        $results = array_diff(array_keys($this->prices), array_keys($multiPrice->prices));
        if ($results) {
            throw new \OutOfRangeException(sprintf(_('Currencies "%s" is not present'), join(', ', $results)));
        }
        foreach ($this->prices as $key => $price) {
            $this->prices[$key]->add($multiPrice->{$key});
        }
    }
}
