<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

use Nette\Utils\Html;

readonly class Message
{
    public function __construct(
        public string|Html $text,
        public MessageLevel $level
    ) {
    }

    /**
     * @phpstan-return array{text:string,level:string}
     */
    public function __toArray(): array
    {
        return [
            'text' => ($this->text instanceof Html) ? $this->text->toHtml() : $this->text,
            'level' => $this->level->value,
        ];
    }
}
