<?php

declare(strict_types=1);

namespace Fykosak\Utils\Tests;

use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Tester\Environment;

require_once __DIR__ . '/../../vendor/autoload.php';

class FakeBootstrap
{
    public static function createContainer(): Container
    {
        Environment::setup();
        $containerLoader = new ContainerLoader(__DIR__ . '/../../tmp');
        /** @phpstan-var class-string<Container> $class */
        $class = $containerLoader->load(function (Compiler $compiler) {
            $compiler->loadConfig(__DIR__ . '/../config.neon');
        });

        return new $class();
    }
}
