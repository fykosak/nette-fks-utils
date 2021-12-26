<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI\Navigation;

use Fykosak\Utils\UI\Title;
use Nette\SmartObject;

class NavItem
{
    use SmartObject;

    public string $destination;
    public array $linkParams;
    public Title $title;
    /** @var NavItem[] */
    public array $children;
    public bool $active;

    public function __construct(
        Title $title,
        string $destination = '#',
        array $linkParams = [],
        array $children = [],
        bool $active = false
    ) {
        $this->active = $active;
        $this->destination = $destination;
        $this->linkParams = $linkParams;
        $this->title = $title;
        $this->children = $children;
    }
}
