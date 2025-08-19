<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

/**
 * @phpstan-template TLang of string
 * @phpstan-template-covariant TValue
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

    /**
     * @phpstan-template TNewValue
     * @param callable(TValue,TLang):TNewValue $callback
     * @return self<TLang,TNewValue>
     */
    public function map(callable $callback): self
    {
        $newValues = [];
        foreach ($this->variants as $lang => $variant) {
            $newValues[$lang] = $callback($variant, $lang);
        }
        return new self($newValues);
    }
    /**
     * @param callable(TValue,TLang):void $callback
     */
    public function forEach(callable $callback): void
    {
        foreach ($this->variants as $lang => &$variant) {
            $callback($variant, $lang);
        }
    }
}
