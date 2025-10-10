<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI\Navigation;

use Fykosak\Utils\UI\LocalizedTitle;
use Fykosak\Utils\UI\Title;

/**
 * @phpstan-template TLang of string
 */
readonly class NavItem
{
    /**
     * @phpstan-param array<string,scalar|null> $linkParams
     * @phpstan-param Title|LocalizedTitle<TLang> $title
     * @param NavItem<TLang>[] $children
     */
    public function __construct(
        public Title|LocalizedTitle $title,
        public string $destination = '#',
        public array $linkParams = [],
        public array $children = [],
        public bool $active = false
    ) {
    }
}
