<?php

declare(strict_types=1);

namespace Fykosak\Utils\Tests;

use Fykosak\Utils\Localization\LangEnum;

enum DummyLang implements LangEnum
{

    public static function getLocales(): array
    {
        return [];
    }

    public function getLocaleDir(): string
    {
        return '';
    }

    public function getLocale(): string
    {
        return '';
    }
}
