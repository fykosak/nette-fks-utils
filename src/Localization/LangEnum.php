<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

interface LangEnum
{
    public static function getLocales(): array;

    public function getLocaleDir(): string;

    public function getLocale(): string;
}
