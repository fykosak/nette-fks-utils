<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

/**
 * @phpstan-template TLang of string
 */
trait LangTrait
{
    /**
     * @phpstan-template TValue
     * @phpstan-param array<TLang,TValue>|LangMap<TLang,TValue> $map
     * @phpstan-return TValue
     */
    final public function getVariant(array|LangMap $map): mixed
    {
        if ($map instanceof LangMap) {
            return $map->get($this->value);
        } else {
            return $map[$this->value];
        }
    }
}
