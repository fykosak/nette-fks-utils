<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

/**
 * @phpstan-template TLang of string
 */
interface LangEnum
{
    /**
     * @phpstan-return array<TLang,string>
     */
    public static function getLocales(): array;

    public function getLocaleDir(): string;

    public function getLocale(): string;
}
