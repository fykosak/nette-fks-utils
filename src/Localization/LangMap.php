<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

/**
 * @phpstan-template TLang of string
 * @phpstan-template TValue
 */
class LangMap
{
    /**
     * @phpstan-var array<TLang,TValue>
     */
    protected array $variants;

    /**
     * @phpstan-param array<TLang,TValue> $variants
     */
    public function __construct(array $variants)
    {
        $this->variants = $variants;
    }

    /**
     * @phpstan-param TLang $lang
     * @phpstan-return TValue
     */
    public function __get(string $lang): mixed
    {
        return $this->get($lang);
    }

    /**
     * @phpstan-param TLang $lang
     * @phpstan-return TValue
     */
    public function get(string $lang): mixed
    {
        return $this->variants[$lang] ?? null;
    }

    /**
     * @phpstan-return array<TLang,TValue>
     */
    public function toArray(): array
    {
        return $this->variants;
    }
}
