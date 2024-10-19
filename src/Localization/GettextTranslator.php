<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

use Nette\Localization\Translator;

/**
 * @phpstan-template TLang of string
 */
class GettextTranslator implements Translator
{
    /** @phpstan-var  \BackedEnum&LangEnum<TLang> */
    public LangEnum & \BackedEnum $lang;


    /** @phpstan-var array<TLang,string> */
    public array $locales;

    /**
     * @phpstan-param class-string<LangEnum>|string $langEnumClass
     */
    public function __construct(
        private readonly string $langEnumClass,
    ) {
    }

    /**
     *
     * @param TLang $lang ISO 639-1
     * @throws UnsupportedLanguageException
     */
    public function setLang(LangEnum & \BackedEnum $lang): void
    {
        if (!$lang instanceof $this->langEnumClass) {
            throw new UnsupportedLanguageException($lang);
        }
        $this->lang = $lang;


        putenv('LANGUAGE=' . $lang->getLocale()); // for the sake of CLI tests
        setlocale(LC_MESSAGES, $lang->getLocale());
        setlocale(LC_TIME, $lang->getLocale());
        bindtextdomain('messages', $lang->getLocaleDir());
        bind_textdomain_codeset('messages', 'utf-8');
        textdomain('messages');
    }

    /**
     * @phpstan-template TValue
     * @phpstan-param array<TLang,TValue>|LangMap<TLang,TValue> $map
     * @phpstan-return TValue
     */
    public function getVariant(array|LangMap $map)
    {
        $this->lang->getVariant($map);
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
            return (string)$this->getVariant($message);
        }
        if (isset($parameters[0])) {
            return ngettext($message, $message, (int)$parameters[0]);
        } else {
            return gettext($message);
        }
    }
}
