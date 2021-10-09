<?php

namespace Fykosak\Utils\UI\Navigation;

use Nette\Application\UI\Control;

/**
 * Compatible with bootstrap >=5.0
 * tested version (5.0,5.1)
 */
class NavigationItemComponent extends Control
{
    public function render(NavItem $item): void
    {
        $this->template->item = $item;
        $this->template->render(__DIR__ . DIRECTORY_SEPARATOR . 'navigationItem.latte');
    }

    public function isItemVisible(NavItem $item): bool
    {
        return true;
    }

    public function isItemActive(NavItem $item): bool
    {
        return false;
    }
}
