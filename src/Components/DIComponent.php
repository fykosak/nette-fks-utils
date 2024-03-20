<?php

declare(strict_types=1);

namespace Fykosak\Utils\Components;

use Fykosak\Utils\Localization\GettextTranslator;
use Nette\Application\UI\{Control, Template};
use Nette\DI\Container;

/**
 * @property \Nette\Bridges\ApplicationLatte\Template $template
 */
abstract class DIComponent extends Control
{
    protected readonly Container $container;
    protected ?GettextTranslator $translator;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $container->callInjects($this);
    }

    protected function getContext(): Container
    {
        return $this->container;
    }

    public function injectTranslator(?GettextTranslator $translator): void
    {
        $this->translator = $translator;
    }

    protected function createTemplate(): Template
    {
        /** @var \Nette\Bridges\ApplicationLatte\Template $template */
        $template = parent::createTemplate();
        $template->setTranslator($this->translator);
        return $template;
    }
}
