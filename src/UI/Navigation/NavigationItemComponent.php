<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI\Navigation;

use Fykosak\Utils\Components\DIComponent;

/**
 * Compatible with bootstrap >=5.0
 * tested version (5.0,5.1)
 * @phpstan-template TLang of string
 * @phpstan-extends DIComponent<TLang>
 */
class NavigationItemComponent extends DIComponent
{
    /**
     * @phpstan-param NavItem<TLang> $item
     */
    public function render(NavItem $item): void
    {
        $this->template->render(__DIR__ . DIRECTORY_SEPARATOR . 'navigationItem.latte', ['item' => $item]);
    }
}
