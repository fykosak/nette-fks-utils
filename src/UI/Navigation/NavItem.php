<?php

namespace Fykosak\Utils\UI\Navigation;

use Fykosak\Utils\UI\PageTitle;
use Nette\SmartObject;

class NavItem
{
    use SmartObject;

    public string $destination;
    public array $linkParams;
    public PageTitle $title;
    /** @var NavItem[] */
    public array $children;

    public function __construct(
        PageTitle $title,
        string $destination = '#',
        array $linkParams = [],
        array $children = []
    ) {
        $this->destination = $destination;
        $this->linkParams = $linkParams;
        $this->title = $title;
        $this->children = $children;
    }
}
