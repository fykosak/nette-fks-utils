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
        public readonly ?string $icon = null,
        public string|Html|null $subTitle = null
    ) {
        $this->id = $id ?? Random::generate(10, 'a-z');
    }

    public function toHtml(bool $includeSubTitle = false): Html
    {
        $container = Html::el('');
        $subContainer = Html::el('span');
        if ($this->icon) {
            $subContainer->addHtml($this->createIcon());
        }
        $subContainer->addAttributes(['class' => 'fks-title']);
        $subContainer->addText($this->title);
        $container->addHtml($subContainer);
        if ($includeSubTitle && $this->subTitle) {
            $container->addHtml(
                Html::el('small')
                    ->addAttributes(['class' => 'ms-2 fks-subtitle'])
                    ->addText($this->subTitle)
            );
        }
        return $container;
    }

    public function createIcon(): Html
    {
        return Html::el('i')->addAttributes(
            [
                'id' => $this->id,
                'class' => $this->icon . ' me-2',
            ]
        );
    }
}
