<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI;

use Nette\Utils\Html;

class PageTitle extends Title
{
    public function __construct(
        ?string $id,
        string|Html $title,
        ?string $icon = null,
        public string|Html|null $subTitle = null
    ) {
        parent::__construct($id, $title, $icon);
    }

    public function toHtml(bool $includeSubTitle = false): Html
    {
        $container = Html::el('');
        $container->addHtml(parent::toHtml());
        if ($includeSubTitle && $this->subTitle) {
            $container->addHtml(
                Html::el('small')
                    ->addAttributes(['class' => 'ms-2 fks-subtitle'])
                    ->addText($this->subTitle)
            );
        }
        return $container;
    }
}
