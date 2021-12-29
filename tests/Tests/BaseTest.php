<?php

declare(strict_types=1);

namespace Fykosak\Utils\Tests;

use Nette\DI\Container;
use Tester\TestCase;

require_once __DIR__ . '/FakeBootstrap.php';

class BaseTest extends TestCase
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
