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
        Assert::exception(fn() => new Currency('XBT'), \Exception::class);
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
        $currencyLower = Currency::from('czk');
        Assert::type(Currency::class, $currencyLower);
    }

    public function testTryFromExists(): void
    {
        $currency = Currency::tryFrom(Currency::CZK);
        Assert::type(Currency::class, $currency);
    }

    public function testFromNonExists(): void
    {
        Assert::exception(fn() => Currency::from('XBT'), \Exception::class);
    }

    public function testTryFromNonExists(): void
    {
        $currency = Currency::tryFrom('XBT');
        Assert::null($currency);
    }
}

$test = new TestCurrency(FakeBootstrap::createContainer());
$test->run();
