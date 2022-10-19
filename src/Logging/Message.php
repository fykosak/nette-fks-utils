<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

use Nette\SmartObject;
use Nette\Utils\Html;

class Message
{
    use SmartObject;

    /** @deprecated */
    public const LVL_ERROR = 'danger';
    /** @deprecated */
    public const LVL_WARNING = 'warning';
    /** @deprecated */
    public const LVL_SUCCESS = 'success';
    /** @deprecated */
    public const LVL_INFO = 'info';
    /** @deprecated */
    public const LVL_PRIMARY = 'primary';

    public readonly MessageLevel $level;

    public function __construct(public readonly string $message, MessageLevel|string $level)
    {
        $this->level = ($level instanceof MessageLevel) ? $level : MessageLevel::from($level);
    }

    public function __toArray(): array
    {
        return [
            'text' => $this->message,
            'level' => $this->level,
        ];
    }
}
