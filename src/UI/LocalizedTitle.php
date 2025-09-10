<?php

declare(strict_types=1);

namespace Fykosak\Utils\UI;

use Fykosak\Utils\Localization\LangMap;
use Nette\Utils\Html;
use Nette\Utils\Random;

/**
 * @phpstan-template TLang of string
 */
class LocalizedTitle
{
    public readonly string $id;

    /**
     * @phpstan-param LangMap<TLang,string|Html> $title
     */
    public function __construct(
        ?string $id,
        public readonly LangMap $title,
        public readonly ?string $icon = null
    ) {
        $this->id = $id ?? Random::generate(10, 'a-z');
    }

    /**
     * @phpstan-return LangMap<TLang,Html>
     */
    public function toHtml(): LangMap
    {
        return $this->title->map(function (string|Html $variant): Html {
            $container = Html::el('span');
            if ($this->icon) {
                $container->addHtml(
                    Html::el('i')->addAttributes([
                        'id' => $this->id,
                        'class' => $this->icon . ' mr-2 me-2',
                    ])
                );
            }
            $container->addText($variant);
            return $container;
        });
    }
}
