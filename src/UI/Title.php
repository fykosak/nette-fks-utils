<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI;

use Nette\Utils\Html;

class Title
{
    public function __construct(
        public string $title,
        public ?string $icon = null,
        public ?string $id = null,
    ) {
    }

    public function toHtml(): Html
    {
        $container = Html::el('span');
        if ($this->icon) {
            $container->addHtml(Html::el('i')->addAttributes(['class' => $this->icon . ' mr-2 me-2']));
        }
        $container->addText($this->title);
        return $container;
    }
}
