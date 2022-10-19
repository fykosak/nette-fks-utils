<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI;

use Nette\Utils\Html;

class PageTitle extends Title
{
    public function __construct(
        ?string $id,
        string $title,
        ?string $icon = null,
        public readonly ?string $subTitle = null
    ) {
        parent::__construct($id, $title, $icon);
    }

    public function toHtml(bool $includeSubHeadline = false): Html
    {
        $container = parent::toHtml();
        if ($includeSubHeadline && $this->subTitle) {
            $container->addHtml(
                Html::el('small')
                    ->addAttributes(['class' => 'ml-2 ms-2 text-secondary small'])
                    ->addText($this->subTitle)
            );
        }
        return $container;
    }
}
