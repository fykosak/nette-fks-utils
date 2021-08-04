<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

use Nette\SmartObject;

class Message
{
    use SmartObject;

    public const LVL_ERROR = 'danger';
    public const LVL_WARNING = 'warning';
    public const LVL_SUCCESS = 'success';
    public const LVL_INFO = 'info';
    public const LVL_PRIMARY = 'primary';

    public string $text;
    public string $level;

    public function __construct(string $message, string $level)
    {
        $this->text = $message;
        $this->level = $level;
    }

    public function __toArray(): array
    {
        return [
            'text' => $this->text,
            'message' => $this->text,
            'level' => $this->level,
        ];
    }
}
