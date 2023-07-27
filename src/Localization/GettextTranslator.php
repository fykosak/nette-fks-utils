<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

use Nette\Localization\Translator;

class GettextTranslator implements Translator
{
    /** @phpstan-var array<string,string> */
    public array $locales;
    private string $localeDir;
    public ?string $lang = null;

    /**
     * @phpstan-param array<string,string> $locales
     */
    public function __construct(array $locales, string $localeDir)
    {
        $this->locales = $locales;
        $this->localeDir = $localeDir;
    }

    /**
     *
     * @param string $lang ISO 639-1
     * @throws UnsupportedLanguageException
     */
    public function setLang(string $lang): void
    {
        $this->lang = $lang;
        if (!isset($this->locales[$lang])) {
            throw new UnsupportedLanguageException($lang);
        }
        $locale = $this->locales[$lang];

        putenv('LANGUAGE=' . $locale); // for the sake of CLI tests
        setlocale(LC_MESSAGES, $locale);
        setlocale(LC_TIME, $locale);
        bindtextdomain('messages', $this->localeDir);
        bind_textdomain_codeset('messages', 'utf-8');
        textdomain('messages');
    }

    /**
     * @return string[]
     */
    public function getSupportedLanguages(): array
    {
        return array_keys($this->locales);
    }

    /**
     * @param mixed|string $message
     * @param string|int $parameters
     */
    public function translate($message, ...$parameters): string
    {
        if ($message === '' || $message === null) {
            return '';
        }
        if (isset($parameters[0])) {
            return ngettext($message, $message, (int)$parameters[0]);
        } else {
            return gettext($message);
        }
    }
}
