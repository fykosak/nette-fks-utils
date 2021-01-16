<?php

namespace Fykosak\Utils\Localization;

use Nette\Localization\Translator;

/**
 *
 * @author Michal Koutný <xm.koutny@gmail.com>
 */
class GettextTranslator implements Translator {

    /** @var array[lang] => locale */
    private array $locales;
    private string $localeDir;

    public function __construct(array $locales, string $localeDir) {
        $this->locales = $locales;
        $this->localeDir = $localeDir;
    }

    /**
     *
     * @param string $lang ISO 639-1
     * @throws UnsupportedLanguageException
     */
    public function setLang(string $lang): void {
        if (!isset($this->locales[$lang])) {
            throw new UnsupportedLanguageException($lang);
        }
        $locale = $this->locales[$lang];

        putenv('LANGUAGE=$locale'); // for the sake of CLI tests
        setlocale(LC_MESSAGES, $locale);
        setlocale(LC_TIME, $locale);
        bindtextdomain('messages', $this->localeDir);
        bind_textdomain_codeset('messages', 'utf-8');
        textdomain('messages');
    }

    /**
     * @return string[]
     */
    public function getSupportedLanguages(): array {
        return array_keys($this->locales);
    }

    /**
     * @param mixed|string $message
     * @param array $parameters
     * @return string
     */
    public function translate($message, ...$parameters): string {
        if ($message === '' || $message === null) {
            return '';
        }
        if (isset($parameters[0])) {
            return ngettext($message, $message, (int)$parameters[0]);
        } else {
            return gettext($message);
        }
    }

    /**
     * @param object $object
     * @param string $field
     * @param string $lang
     * @return mixed
     */
    public static function i18nHelper(object $object, string $field, string $lang) {
        return $object->{$field . '_' . $lang};
    }
}
