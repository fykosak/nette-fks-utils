<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

use Nette\Localization\Translator;

class GettextTranslator implements Translator
{
    /** @param class-string<LangEnum>|string $langEnumClass */
    public function __construct(
        private readonly string $langEnumClass,
    ) {
    }

    /**
     * @throws UnsupportedLanguageException
     */
    public function setLang(LangEnum & \BackedEnum $lang): void
    {
        if (!$lang instanceof $this->langEnumClass) {
            throw new UnsupportedLanguageException($lang);
        }
        putenv('LANGUAGE=' . $lang->getLocale()); // for the sake of CLI tests
        setlocale(LC_MESSAGES, $lang->getLocale());
        setlocale(LC_TIME, $lang->getLocale());
        bindtextdomain('messages', $lang->getLocaleDir());
        bind_textdomain_codeset('messages', 'utf-8');
        textdomain('messages');
    }

    /**
     * @return string[]
     */
    public function getSupportedLanguages(): array
    {
        return $this->langEnumClass::cases();
    }

    /**
     * @param mixed|string $message
     * @param array $parameters
     * @return string
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
