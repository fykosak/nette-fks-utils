<?php

declare(strict_types=1);

namespace Fykosak\Utils\Tests\Price;

use Fykosak\Utils\Price\Currency;
use Fykosak\Utils\Tests\BaseTest;
use Fykosak\Utils\Tests\FakeBootstrap;
use Tester\Assert;

require_once __DIR__ . '/../FakeBootstrap.php';

class TestCurrency extends BaseTest
{
    public function testCreateNonExist(): void
    {
        Assert::exception(fn() => new Currency('XBT'), \ValueError::class);
    }

    public function testCases(): void
    {
        foreach (Currency::cases() as $case) {
            Assert::type(Currency::class, $case);
        }
    }

    public function testFromExists(): void
    {
        $currency = Currency::from(Currency::CZK);
        Assert::type(Currency::class, $currency);
    }

    public function testTryFromExists(): void
    {
        $currency = Currency::tryFrom(Currency::CZK);
        Assert::type(Currency::class, $currency);
    }

    public function testFromNonExists(): void
    {
        Assert::exception(fn() => Currency::from('XBT'), \ValueError::class);
    }

    public function testTryFromNonExists(): void
    {
        $currency = Currency::tryFrom('XBT');
        Assert::null($currency);
    }

    public function testRender(): void
    {
        $currency = new Currency(Currency::CZK);
        Assert::same('2.00 Kč', $currency->format(2.0));
    }
}

$test = new TestCurrency(FakeBootstrap::createContainer());
$test->run();
