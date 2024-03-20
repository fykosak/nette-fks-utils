<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI\Navigation;

use Fykosak\Utils\Components\DIComponent;

/**
 * Compatible with bootstrap >=5.0
 * tested version (5.0,5.1)
 */
class NavigationItemComponent extends DIComponent
{
    public function render(NavItem $item): void
    {
        $this->template->render(__DIR__ . DIRECTORY_SEPARATOR . 'navigationItem.latte', ['item' => $item]);
    }
}
