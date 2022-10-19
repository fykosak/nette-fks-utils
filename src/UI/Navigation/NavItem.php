<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI\Navigation;

use Fykosak\Utils\UI\Title;
use Nette\SmartObject;

class NavItem
{
    use SmartObject;

    public function __construct(
        public readonly Title $title,
        public readonly string $destination = '#',
        public readonly array $linkParams = [],
        /** @var NavItem[] */
        public readonly array $children = [],
        public readonly bool $active = false
    ) {
    }
}
