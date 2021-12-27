<?php

declare(strict_types=1);

namespace Fykosak\Utils\Tests;

use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Tester\Environment;

require_once __DIR__ . '/../../vendor/autoload.php';

class FakeBootstrap
{
    public static function createContainer(): Container
    {
        Environment::setup();
        $containerLoader = new ContainerLoader(__DIR__ . '/../tmp');
        $class = $containerLoader->load(function ($compiler) {
            $compiler->loadConfig(__DIR__ . '/../config.neon');
        });

        return new $class();
    }
}
