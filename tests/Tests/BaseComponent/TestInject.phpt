<?php

declare(strict_types=1);

namespace Fykosak\Utils\Tests\BaseComponent;

use Fykosak\Utils\Tests\DummyService;
use Fykosak\Utils\Tests\FakeBootstrap;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../FakeBootstrap.php';

class TestInject extends TestCase
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function testInject(): void
    {
        $component = new DummyComponent($this->container);
        Assert::type(DummyService::class, $component->dummyService);
    }
}

$testCase = new TestInject(FakeBootstrap::createContainer());
$testCase->run();
