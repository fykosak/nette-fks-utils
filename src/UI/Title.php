<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI;

use Nette\Utils\Html;
use Nette\Utils\Random;

class Title
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $icon = null,
        public readonly ?string $id = null,
    ) {
    }

    public function toHtml(): Html
    {
        $container = Html::el('span');
        if ($this->icon) {
            $container->addHtml(
                Html::el('i')->addAttributes(
                    [
                        'id' => $this->id ?? Random::generate(10, 'a-z'),
                        'class' => $this->icon . ' mr-2 me-2',
                    ]
                )
            );
        }
        $container->addText($this->title);
        return $container;
    }
}
