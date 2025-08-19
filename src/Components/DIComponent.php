<?php

declare(strict_types=1);

namespace Fykosak\Utils\Components;

use Fykosak\Utils\Localization\GettextTranslator;
use Fykosak\Utils\Localization\LangMap;
use Fykosak\Utils\Logging\MessageLevel;
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

    protected function createTemplate(?string $class = null): Template
    {
        /** @var \Nette\Bridges\ApplicationLatte\Template $template */
        $template = parent::createTemplate();
        $template->setTranslator($this->translator);
        $template->translator = $this->translator;
        return $template;
    }

    /**
     * @phpstan-param \Stringable|string|\stdClass|LangMap<'cs'|'en',\Stringable|string|\stdClass> $message
     */
    public function flashMessage(
        \Stringable|string|\stdClass|LangMap $message,
        string|MessageLevel $type = 'info'
    ): \stdClass {
        if ($message instanceof LangMap) {
            $message = $message->get($this->translator ? $this->translator->lang : 'en');
        }
        if ($type instanceof MessageLevel) {
            $type = $type->value;
        }
        return parent::flashMessage($message, $type);
    }
}
