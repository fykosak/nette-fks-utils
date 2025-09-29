<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI;

use Fykosak\Utils\Localization\LangMap;
use Nette\Utils\Html;
use Nette\Utils\Random;

/**
 * @phpstan-template TLang of string
 */
readonly class LocalizedTitle
{
    public string $id;
    /**
     * @phpstan-param LangMap<TLang,string|Html> $title
     * @phpstan-param LangMap<TLang,string|Html>|null $subTitle
     */
    public function __construct(
        ?string $id,
        public LangMap $title,
        public ?string $icon = null,
        public ?LangMap $subTitle = null
    ) {
        $this->id = $id ?? Random::generate(10, 'a-z');
    }

    /**
     * @phpstan-return LangMap<TLang,Html>
     */
    public function toHtml(bool $includeSubTitle = false): LangMap
    {
        $title = $this->title->map(function (string|Html $variant): Html {
            $container = Html::el('span');
            if ($this->icon) {
                $container->addHtml($this->createIcon());
            }
            $container->addAttributes(['class' => 'fks-title']);
            $container->addText($variant);
            return $container;
        });
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
