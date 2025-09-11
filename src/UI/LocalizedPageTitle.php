<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI;

use Fykosak\Utils\Localization\LangMap;
use Nette\Utils\Html;

/**
 * @phpstan-template TLang of string
 * @phpstan-extends LocalizedTitle<TLang>
 */
class LocalizedPageTitle extends LocalizedTitle
{
    /**
     * @phpstan-param LangMap<TLang,string|Html> $title
     * @phpstan-param LangMap<TLang,string|Html>|null $subTitle
     */
    public function __construct(
        ?string $id,
        LangMap $title,
        ?string $icon = null,
        public ?LangMap $subTitle = null
    ) {
        parent::__construct($id, $title, $icon);
    }

    public function toHtml(bool $includeSubTitle = false): LangMap
    {
        $title = parent::toHtml();
        if (isset($this->subTitle) && $includeSubTitle) {
            return $title->mapWith(function (Html $variant, string $lang, Html|string $subTitle): Html {
                $container = Html::el('');
                $container->addHtml($variant);
                $container->addHtml(
                    Html::el('small')
                        ->addAttributes(['class' => 'ms-2 fks-subtitle'])
                        ->addText($subTitle)
                );
                return $container;
            }, $this->subTitle);
        }
        return $title;
    }
}
