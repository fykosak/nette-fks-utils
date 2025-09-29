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
        $price1 = new Price(Currency::CZK, 2);
        $price2 = new Price(Currency::CZK, 4);
        $newPrice = $price1->add($price2);
        Assert::same(6.0, $newPrice->amount);
        Assert::same(2.0, $price1->amount);
        Assert::same(4.0, $price2->amount);
    }

    public function testNotSame(): void
    {
        $price1 = new Price(Currency::CZK, 2);
        $price2 = new Price(Currency::EUR, 4);
        Assert::exception(fn() => $price1->add($price2), \LogicException::class);
    }

    public function testAdd(): void
    {
        $price1 = new Price(Currency::CZK, 2);
        $newPrice = $price1->add(3.5);
        Assert::same(2.0, $price1->amount);
        Assert::same(5.5, $newPrice->amount);
    }
}

$test = new TestPrice(FakeBootstrap::createContainer());
$test->run();
