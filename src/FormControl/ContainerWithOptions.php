<?php

declare(strict_types=1);

namespace Fykosak\Utils\FormControl;

use Fykosak\Utils\Localization\GettextTranslator;
use Nette\DI\Container as DIContainer;
use Nette\Forms\Container;
use Nette\Forms\Controls\BaseControl;

class ContainerWithOptions extends Container
{
    /** @phpstan-var array<string,mixed> */
    private array $options = [];

    public bool $collapse = false;

    protected DIContainer $container;
    /** @phpstan-var GettextTranslator<'cs'|'en'> */
    protected GettextTranslator $translator;

    public function __construct(DIContainer $container)
    {
        $this->container = $container;
        $container->callInjects($this);
    }

    /**
     * @phpstan-param GettextTranslator<'cs'|'en'> $translator
     */
    final public function injectTranslator(GettextTranslator $translator): void
    {
        $this->translator = $translator;
    }

    /**
     * Sets user-specific option.
     * Options recognized by DefaultFormRenderer
     * - 'description' - textual or Html object description
     *
     * @phpstan-template TNewValue
     * @phpstan-param TNewValue $value
     */
    public function setOption(string $key, mixed $value): static
    {
        if ($value === null) {
            unset($this->options[$key]);
        } else {
            $this->options[$key] = $value;
        }
        return $this;
    }

    final public function getOption(string $key): mixed
    {
        return $this->options[$key] ?? null;
    }

    /**
     * Returns user-specific options.
     * @phpstan-return array<string,mixed>
     */
    final public function getOptions(): array
    {
        return $this->options;
    }

    public function setDisabled(bool $value = true): void
    {
        /** @var self|BaseControl $component */
        foreach ($this->getComponents() as $component) {
            $component->setDisabled($value);
        }
    }

    public function setHtmlAttribute(string $name, mixed $value = true): static
    {
        /** @var self|BaseControl $component */
        foreach ($this->getComponents() as $component) {
            $component->setHtmlAttribute($name, $value);
        }
        return $this;
    }
}
