<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

use Nette\SmartObject;

class Message
{
    use SmartObject;

    public function __construct(public readonly string $message, public readonly MessageLevel $level)
    {
    }

    public function __toArray(): array
    {
        return [
            'text' => $this->message,
            'level' => $this->level,
        ];
    }
}
