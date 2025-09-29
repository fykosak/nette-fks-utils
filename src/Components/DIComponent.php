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
 * @phpstan-template TLang of string
 * @property \Nette\Bridges\ApplicationLatte\Template $template
 */
abstract class DIComponent extends Control
{
    /** @phpstan-var GettextTranslator<TLang> */
    protected GettextTranslator $translator;

    public function __construct(
        protected readonly Container $container
    ) {
        $container->callInjects($this);
    }

    /** @phpstan-param GettextTranslator<TLang>|null $translator */
    public function injectTranslator(?GettextTranslator $translator): void
    {
        if (isset($translator)) {
            $this->translator = $translator;
        }
    }

    protected function createTemplate(?string $class = null): Template
    {
        /** @var \Nette\Bridges\ApplicationLatte\Template $template */
        $template = parent::createTemplate();
        $template->setTranslator($this->translator);
        $template->translator = $this->translator; //@phpstan-ignore-line
        return $template;
    }

    /**
     * @phpstan-param \Stringable|string|\stdClass|LangMap<TLang,\Stringable|string|\stdClass> $message
     */
    public function flashMessage(
        \Stringable|string|\stdClass|LangMap $message,
        string|MessageLevel $type = 'info'
    ): \stdClass {
        if ($message instanceof LangMap) {
            /** @var \Stringable|string|\stdClass  $message */
            $message = $this->translator->getVariant($message);
        }
        if ($type instanceof MessageLevel) {
            $type = $type->value;
        }
        return parent::flashMessage($message, $type);
    }
}
