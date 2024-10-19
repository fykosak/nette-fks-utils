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
     * @phpstan-param TLang $key
     * @phpstan-return TValue
     */
    public function get(string $key): mixed
    {
        return $this->variants[$key] ?? null;
    }

    /**
     * @phpstan-return array<TLang,TValue>
     */
    public function __serialize(): array
    {
        return $this->variants;
    }
}
