<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI;

use Nette\Utils\Html;
use Nette\Utils\Random;

class Title
{
    public string $title;
    public ?string $icon;
    public ?string $id;

    public function __construct(?string $id, string $title, ?string $icon = null)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->id = $id;
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
