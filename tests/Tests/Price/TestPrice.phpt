<?php

declare(strict_types=1);

namespace Fykosak\Utils\Tests\Price;

use Fykosak\Utils\Price\Currency;
use Fykosak\Utils\Price\Price;
use Fykosak\Utils\Tests\BaseTest;
use Fykosak\Utils\Tests\FakeBootstrap;
use Tester\Assert;

require_once __DIR__ . '/../FakeBootstrap.php';

class TestPrice extends BaseTest
{
    public function testAddSame(): void
    {
        $price1 = new Price(new Currency(Currency::CZK), 2);
        $price2 = new Price(new Currency(Currency::CZK), 4);
        $price1->add($price2);
        Assert::same(6.0, $price1->getAmount());
        Assert::same(4.0, $price2->getAmount());
    }

    public function testNotSame(): void
    {
        $price1 = new Price(new Currency(Currency::CZK), 2);
        $price2 = new Price(new Currency(Currency::EUR), 4);
        Assert::exception(fn() => $price1->add($price2), \LogicException::class);
    }

    public function testAdd(): void
    {
        $price1 = new Price(new Currency(Currency::CZK), 2);
        $price1->addAmount(3.5);
        Assert::same(5.5, $price1->getAmount());
    }
}

$test = new TestPrice(FakeBootstrap::createContainer());
$test->run();
