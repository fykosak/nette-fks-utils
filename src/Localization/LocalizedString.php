<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

/**
 * @template TLang of string
 * @deprecated
 * @phpstan-extends LangMap<TLang,string>
 */
class LocalizedString extends LangMap
{
    /**
     * @phpstan-param TLang $lang
     */
    public function getText(string $lang): ?string
    {
        return $this->variants[$lang] ?? null;
    }

    public function __toString(): string
    {
        return join('/', $this->variants);
    }
}
