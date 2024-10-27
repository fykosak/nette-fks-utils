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
        Assert::exception(fn() => $multiPrice->czk, \OutOfRangeException::class);
    }

    public function testCreateFilled(): void
    {
        $multiPrice = new MultiCurrencyPrice([new Price(Currency::CZK)]);
        $price = $multiPrice->czk;
        Assert::type(Price::class, $price);
    }

    public function testGetAccess(): void
    {
        $multiPrice = new MultiCurrencyPrice([new Price(Currency::CZK, 4),]);
        Assert::type(Price::class, $multiPrice->czk);
        Assert::exception(fn() => $multiPrice->eur, \OutOfRangeException::class);
        Assert::type(Price::class, $multiPrice->CZK);
    }

    public function testSetAccess(): void
    {
        $multiPrice = new MultiCurrencyPrice([new Price(Currency::CZK, 4),]);
        $multiPrice->czk = new Price(Currency::CZK, 2);
        Assert::type(Price::class, $multiPrice->czk);
        Assert::same(2.0, $multiPrice->czk->getAmount());

        Assert::exception(
            fn() => $multiPrice->czk = new Price(Currency::EUR),
            \LogicException::class
        );
        Assert::exception(
            fn() => $multiPrice->CZK = new Price(Currency::EUR),
            \LogicException::class
        );
        Assert::exception(
            fn() => $multiPrice->eur = new Price(Currency::EUR),
            \OutOfRangeException::class
        );
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

        $multiPrice1->add($multiPrice2);

        Assert::exception(
            fn() => $multiPrice1->eur,
            \OutOfRangeException::class
        ); // still unset

        Assert::type(Price::class, $multiPrice1->czk);
        Assert::same(3.0, $multiPrice1->czk->getAmount());

        Assert::exception(
            fn() => $multiPrice2->add($multiPrice1),
            \OutOfRangeException::class
        );
    }
}

$testCase = new TestMultiPrice(FakeBootstrap::createContainer());
$testCase->run();
