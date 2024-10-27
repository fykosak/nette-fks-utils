<?php

declare(strict_types=1);

namespace Fykosak\Utils\Components;

use Fykosak\Utils\Localization\GettextTranslator;
use Nette\Application\UI\Control;
use Nette\Application\UI\Template;
use Nette\DI\Container;

/**
 * @property \Nette\Bridges\ApplicationLatte\Template $template
 */
abstract class DIComponent extends Control
{
    protected ?GettextTranslator $translator;

    public function __construct(
        protected readonly Container $container
    ) {
        $container->callInjects($this);
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
        $template->translator = $this->translator;
        return $template;
    }
}
