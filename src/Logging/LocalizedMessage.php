<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

use Fykosak\Utils\Localization\LangMap;
use Nette\Utils\Html;

/**
 * @phpstan-template TLang of string = string
 */
readonly class LocalizedMessage
{
    /**
     * @phpstan-param LangMap<TLang,Html|string> $text
     */
    public function __construct(
        public LangMap $text,
        public MessageLevel $level
    ) {
    }

    /**
     * @phpstan-return array{text:array<TLang,string>,level:string}
     */
    public function __toArray(): array
    {
        return [
            'text' => $this->text->map(
                fn(Html|string $value): string => ($value instanceof Html) ? $value->toHtml() : $value
            )->toArray(),
            'level' => $this->level->value,
        ];
    }
}
