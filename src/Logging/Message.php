<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

use Nette\SmartObject;
use Nette\Utils\Html;

class Message
{
    use SmartObject;

    public string|Html $text;
    public MessageLevel $level;

    public function __construct(string|Html $message, MessageLevel $level)
    {
        $this->text = $message;
        $this->level = $level;
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
