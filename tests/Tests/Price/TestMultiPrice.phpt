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
        $price = $multiPrice->getPrice(Currency::from(Currency::CZK));
        Assert::null($price);
    }

    public function testCreateFilled(): void
    {
        $multiPrice = new MultiCurrencyPrice([new Price(Currency::from(Currency::CZK))]);
        $price = $multiPrice->getPrice(Currency::from(Currency::CZK));
        Assert::type(Price::class, $price);
        $anotherPrice = $multiPrice->getPrice(Currency::from(Currency::EUR));
        Assert::null($anotherPrice);
    }

    public function testGetAccess(): void
    {
        $multiPrice = new MultiCurrencyPrice(
            [
                new Price(Currency::from(Currency::CZK), 4),
            ]
        );
        Assert::type(Price::class, $multiPrice->czk);
        Assert::null($multiPrice->eur);
    }

    public function testSetAccess(): void
    {
        $multiPrice = new MultiCurrencyPrice(
            [
                new Price(Currency::from(Currency::CZK), 4),
            ]
        );
        $multiPrice->czk = new Price(Currency::from(Currency::CZK), 2);
        Assert::type(Price::class, $multiPrice->czk);
        Assert::same(2.0, $multiPrice->czk->getAmount());
        Assert::exception(fn() => $multiPrice->czk = new Price(Currency::from(Currency::EUR)), \Exception::class);
    }

    public function testCreateSum(): void
    {
        $multiPrice1 = new MultiCurrencyPrice([new Price(Currency::from(Currency::CZK), 2)]);
        $eurPriceBefore = new Price(Currency::from(Currency::EUR), 4);
        $multiPrice2 = new MultiCurrencyPrice(
            [
                new Price(Currency::from(Currency::CZK), 1),
                $eurPriceBefore,
            ]
        );

        $multiPrice1->add($multiPrice2);
        $eurPrice = $multiPrice1->getPrice(Currency::from(Currency::EUR));
        Assert::type(Price::class, $eurPrice);
        Assert::notSame($eurPriceBefore, $eurPrice);
        Assert::same(4.0, $eurPrice->getAmount());

        $czkPrice = $multiPrice1->getPrice(Currency::from(Currency::CZK));
        Assert::type(Price::class, $czkPrice);
        Assert::same(3.0, $czkPrice->getAmount());
    }
}

$testCase = new TestMultiPrice(FakeBootstrap::createContainer());
$testCase->run();
