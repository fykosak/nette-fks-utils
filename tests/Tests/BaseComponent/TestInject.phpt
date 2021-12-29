<?php

declare(strict_types=1);

namespace Fykosak\Utils\Tests\BaseComponent;

use Fykosak\Utils\Tests\BaseTest;
use Fykosak\Utils\Tests\DummyService;
use Fykosak\Utils\Tests\FakeBootstrap;
use Tester\Assert;

require_once __DIR__ . '/../FakeBootstrap.php';

class TestInject extends BaseTest
{
    public function testInject(): void
    {
        $component = new DummyComponent($this->container);
        Assert::type(DummyService::class, $component->dummyService);
    }
}

$testCase = new TestInject(FakeBootstrap::createContainer());
$testCase->run();
