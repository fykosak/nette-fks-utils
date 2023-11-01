<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI;

use Nette\Utils\Html;

class PageTitle extends Title
{
    /** @var string|Html|null */
    public $subTitle;

    /**
     * @param string|Html $title
     * @param string|Html|null $subTitle
     */
    public function __construct(?string $id, $title, ?string $icon = null, $subTitle = null)
    {
        parent::__construct($id, $title, $icon);
        $this->subTitle = $subTitle;
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
