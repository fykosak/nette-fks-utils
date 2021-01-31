<?php

namespace Fykosak\Utils\FrontEndComponents;

use Nette\Application\UI\Component;
use Nette\Application\UI\InvalidLinkException;
use Nette\SmartObject;

class NetteActions {
    use SmartObject;

    private array $actions = [];
    private Component $component;

    public function __construct(Component $component) {
        $this->component = $component;
    }

    /**
     * @param string $key
     * @param string $destination
     * @param array $params
     * @throws InvalidLinkException
     */
    public function addAction(string $key, string $destination, array $params = []): void {
        $this->actions[$key] = $this->component->link($destination, $params);
    }

    public function removeAction(string $key): void {
        unset($this->actions[$key]);
    }

    public function hasAction($key): bool {
        return isset($this->actions[$key]);
    }

    public function serialize(): string {
        return json_encode($this->actions);
    }
}
