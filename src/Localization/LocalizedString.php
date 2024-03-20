<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

/**
 * @template TLangs of string
 */
class LocalizedString
{
    /**
     * @phpstan-var array<TLangs,string>
     */
    private array $texts;

    /**
     * @phpstan-param array<TLangs,string> $texts
     */
    public function __construct(array $texts)
    {
        $this->texts = $texts;
    }

    public function getText(LangEnum & \BackedEnum $lang): ?string
    {
        return $this->texts[$lang->value] ?? null;
    }

    /**
     * @phpstan-return array<TLangs,string>
     */
    public function __serialize(): array
    {
        return $this->texts;
    }
}
