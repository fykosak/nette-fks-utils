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
    )
    {
        parent::__construct($id, $title, $icon);
    }

    public function toHtml(bool $includeSubTitle = false): Html
    {
        $container = parent::toHtml();
        if ($includeSubTitle && $this->subTitle) {
            $container->addHtml(
                Html::el('small')
                    ->addAttributes(['class' => 'ml-2 ms-2 text-secondary small'])
                    ->addText($this->subTitle)
            );
        }
        return $container;
    }
}
