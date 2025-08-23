<?php

declare(strict_types=1);

namespace Fykosak\Utils\FrontendComponent\NetteActions;

use Nette\Application\UI\Component;
use Nette\Application\UI\InvalidLinkException;
use Nette\InvalidStateException;

class NetteActions
{
    /**
     * @phpstan-var array<string,string>
     */
    private array $actions = [];

    public function __construct(
        private readonly Component $component
    ) {
    }

    /**
     * @throws InvalidLinkException
     * @phpstan-param array<string,scalar> $params
     */
    public function addAction(string $key, string $destination, array $params = []): void
    {
        $this->actions[$key] = $this->component->link($destination, $params);
    }

    /**
     * @throws InvalidLinkException
     * @phpstan-param array<string,scalar> $params
     */
    public function addPresenterLink(string $key, string $destination, array $params = []): void
    {
        $presenter = $this->component->getPresenter();
        if (!$presenter) {
            throw new InvalidStateException();
        }
        $this->actions[$key] = $presenter->link($destination, $params);
    }

    public function removeAction(string $key): void
    {
        unset($this->actions[$key]);
    }

    public function hasAction(string $key): bool
    {
        return isset($this->actions[$key]);
    }

    /**
     * @phpstan-return array<string,string>
     */
    public function getActions(): array
    {
        return $this->actions;
    }
}
