<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI\Navigation;

use Fykosak\Utils\UI\LocalizedTitle;
use Fykosak\Utils\UI\Title;

/**
 * @phpstan-template TLang of string
 */
class NavItem
{
    /**
     * @phpstan-param array<string,scalar> $linkParams
     * @phpstan-param Title|LocalizedTitle<TLang> $title
     * @param NavItem<TLang>[] $children
     */
    public function __construct(
        public readonly Title|LocalizedTitle $title,
        public readonly string $destination = '#',
        public readonly array $linkParams = [],
        public readonly array $children = [],
        public readonly bool $active = false
    ) {
    }
}
