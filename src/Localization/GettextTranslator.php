<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

use Nette\Localization\Translator;

/**
 * @phpstan-template TLang of string
 */
class GettextTranslator implements Translator
{
    /** @phpstan-var array<TLang,string> */
    public array $locales;
    private string $localeDir;
    /** @phpstan-var TLang */
    public string $lang;

    /**
     * @phpstan-param array<TLang,string> $locales
     */
    public function __construct(array $locales, string $localeDir)
    {
        $this->locales = $locales;
        $this->localeDir = $localeDir;
    }

    /**
     *
     * @param TLang $lang ISO 639-1
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
     * @return TLang[]
     */
    public function getSupportedLanguages(): array
    {
        return array_keys($this->locales);
    }

    /**
     * @phpstan-template TValue
     * @phpstan-param array<TLang,TValue>|LangMap<TLang,TValue> $map
     * @phpstan-return TValue
     */
    public function getVariant($map)
    {
        if ($map instanceof LangMap) {
            return $map->get($this->lang);
        } elseif (is_array($map)) {
            return $map[$this->lang];
        }
        throw new \InvalidArgumentException();//@phpstan-ignore-line
    }

    /**
     * @param array|LangMap|string|null $message
     * @param string|int $parameters
     */
    public function translate($message, ...$parameters): string
    {

        if ($message === '' || $message === null) {
            return '';
        }
        if (is_array($message)) {
            return (string)$this->getVariant($message);
        }
        if ($message instanceof LangMap) {
            return (string)$message->get($this->lang);
        }
        if (isset($parameters[0])) {
            return ngettext($message, $message, (int)$parameters[0]);
        } else {
            return gettext($message);
        }
    }
}
