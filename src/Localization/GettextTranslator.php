<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

use Fykosak\Utils\Price\Price;
use Nette\Localization\Translator;

/**
 * @phpstan-template TLang of string
 */
class GettextTranslator implements Translator
{
    /** @phpstan-var TLang */
    public string $lang;

    /**
     * @phpstan-param array<TLang,string> $locales
     */
    public function __construct(
        public readonly array $locales,
        private readonly string $localeDir
    ) {
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

    public function formatCurrency(Price $price): string
    {
        $formater = new \NumberFormatter($this->locales[$this->lang], \NumberFormatter::CURRENCY);
        return $formater->formatCurrency($price->amount, $price->currency->value);
    }

    /**
     * @phpstan-template TValue
     * @phpstan-param array<TLang|"",TValue>|LangMap<TLang,TValue> $map
     * @phpstan-return TValue
     */
    public function getVariant(array|LangMap $map): mixed
    {
        if ($map instanceof LangMap) {
            return $map->get($this->lang);
        } else {
            return $map[$this->lang] ?? $map[''] ?? throw new \OutOfRangeException();
        }
    }

    /**
     * @phpstan-param LangMap<TLang,string|\Stringable>|array<TLang|"",string|\Stringable>|string|null $message
     */
    public function translate(string|\Stringable|LangMap|array|null $message, mixed ...$parameters): string
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
            return ngettext($message, $message, (int)$parameters[0]); //@phpstan-ignore-line
        } else {
            return gettext($message);
        }
    }
}
