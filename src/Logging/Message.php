<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

use Nette\SmartObject;
use Nette\Utils\Html;

class Message
{
    use SmartObject;

    public function __construct(
        public readonly string|Html $text,
        public readonly MessageLevel $level,
    ) {
    }

    public function __toArray(): array
    {
        return [
            'text' => (string)$this->text,
            'message' => (string)$this->text,
            'level' => $this->level->value,
        ];
    }
}
