<?php

declare(strict_types=1);

namespace Fykosak\Utils\Tests\Price;

use Fykosak\Utils\Price\Currency;
use Fykosak\Utils\Price\MultiCurrencyPrice;
use Fykosak\Utils\Price\Price;
use Fykosak\Utils\Tests\BaseTest;
use Fykosak\Utils\Tests\FakeBootstrap;
use Tester\Assert;

require_once __DIR__ . '/../FakeBootstrap.php';

class TestMultiPrice extends BaseTest
{
    public function testCreateEmpty(): void
    {
        $multiPrice = new MultiCurrencyPrice();
        Assert::error(fn() => $multiPrice->getPrice(Currency::CZK), \OutOfRangeException::class);
    }

    public function testCreateFilled(): void
    {
        $multiPrice = new MultiCurrencyPrice([new Price(Currency::CZK)]);
        $price = $multiPrice->getPrice(Currency::CZK);
        Assert::type(Price::class, $price);
    }

    public function testGetAccess(): void
    {
        $multiPrice = new MultiCurrencyPrice([new Price(Currency::CZK, 4),]);
        Assert::type(Price::class, $multiPrice->getPrice(Currency::CZK));
        Assert::exception(fn() => $multiPrice->getPrice(Currency::EUR), \OutOfRangeException::class);
        Assert::type(Price::class, $multiPrice->getPrice(Currency::CZK));
    }

    public function testCreateSum(): void
    {
        $multiPrice1 = new MultiCurrencyPrice([new Price(Currency::CZK, 2)]);
        $multiPrice2 = new MultiCurrencyPrice(
            [
                new Price(Currency::CZK, 1),
                new Price(Currency::EUR, 4),
            ]
        );

        $newPrice = $multiPrice1->add($multiPrice2);

        Assert::exception(
            fn() => $newPrice->getPrice(Currency::EUR),
            \OutOfRangeException::class
        ); // still unset

        Assert::type(Price::class, $newPrice->getPrice(Currency::CZK));
        Assert::same(3.0, $newPrice->getPrice(Currency::CZK)->amount);

        Assert::exception(
            fn() => $multiPrice2->add($multiPrice1),
            \OutOfRangeException::class
        );
    }
}

$testCase = new TestMultiPrice(FakeBootstrap::createContainer());
$testCase->run();
