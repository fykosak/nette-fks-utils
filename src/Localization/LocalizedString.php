<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

/**
 * @template L of string
 */
class LocalizedString
{
    /**
     * @phpstan-var array<L,string>
     */
    private array $texts;

    /**
     * @phpstan-param array<L,string> $texts
     */
    public function __construct(array $texts)
    {
        $this->texts = $texts;
    }

    /**
     * @phpstan-param L $lang
     */
    public function __get(string $lang): ?string
    {
        return $this->getText($lang);
    }

    /**
     * @phpstan-param L $lang
     */
    public function getText(string $lang): ?string
    {
        return $this->texts[$lang] ?? null;
    }

    /**
     * @phpstan-return array<L,string>
     */
    public function __serialize(): array
    {
        return $this->texts;
    }

    public function __toString(): string
    {
        return join('/', $this->texts);
    }
}
