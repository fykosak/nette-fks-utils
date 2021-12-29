<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

use Nette\SmartObject;

class MultiCurrencyPrice
{
    use SmartObject;

    /** @var Price[] */
    protected array $prices;

    public function __construct(?array $prices = [])
    {
        foreach ($prices as $price) {
            $this->addPrice($price);
        }
    }

    /**
     * @throws \Exception
     */
    public function __get(string $name): ?Price
    {
        return $this->getPrice(Currency::from($name));
    }

    /**
     * @throws \Exception
     */
    public function __set(string $name, Price $value): void
    {
        if ($value->getCurrency()->value !== $name) {
            throw new \Exception();
        }
        $this->addPrice($value, true);
    }

    /**
     * @throws \LogicException
     */
    public function add(self $multiPrice): void
    {
        foreach ($multiPrice->prices as $key => $price) {
            if (isset($this->prices[$key])) {
                $this->prices[$key]->add($price);
            } else {
                $this->addPrice(clone $price);
            }
        }
    }

    public function getPrice(Currency $currency): ?Price
    {
        return $this->prices[$currency->value] ?? null;
    }

    public function addPrice(Price $price, bool $overwrite = false): void
    {
        if (!isset($this->prices[$price->getCurrency()->value]) || $overwrite) {
            $this->prices[$price->getCurrency()->value] = $price;
        }
    }
}
