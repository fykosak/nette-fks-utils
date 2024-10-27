<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI;

use Nette\Utils\Html;
use Nette\Utils\Random;

class Title
{
    public readonly string $id;

    public function __construct(
        ?string $id,
        public readonly string|Html $title,
        public readonly ?string $icon = null
    ) {
        $this->id = $id ?? Random::generate(10, 'a-z');
    }

    public function toHtml(): Html
    {
        $container = Html::el('span');
        if ($this->icon) {
            $container->addHtml(
                Html::el('i')->addAttributes(
                    [
                        'id' => $this->id,
                        'class' => $this->icon . ' mr-2 me-2',
                    ]
                )
            );
        }
        $container->addText($this->title);
        return $container;
    }
}
