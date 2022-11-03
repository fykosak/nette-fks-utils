<?php

declare(strict_types=1);

namespace Fykosak\Utils\Components;

use Nette\Application\UI\{Control, Template};
use Nette\DI\Container;
use Nette\Localization\Translator;

abstract class DIComponent extends Control
{
    protected readonly Container $container;
    protected ?Translator $translator;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $container->callInjects($this);
    }

    public function injectTranslator(?Translator $translator): void
    {
        $this->translator = $translator;
    }

    protected function createTemplate(): Template
    {
        $template = parent::createTemplate();
        $template->setTranslator($this->translator);
        return $template;
    }
}
