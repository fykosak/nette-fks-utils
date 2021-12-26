<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI\Navigation;

use Fykosak\Utils\UI\Title;
use Nette\SmartObject;

class NavItem
{
    use SmartObject;

    /** @param NavItem[] $children */
    public function __construct(
        public Title $title,
        public string $destination = '#',
        public array $linkParams = [],
        public array $children = [],
        public bool $active = false
    ) {
    }
}
