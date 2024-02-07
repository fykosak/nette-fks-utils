<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

use Nette\SmartObject;
use Nette\Utils\Html;

class Message
{
    use SmartObject;

    public const LVL_ERROR = 'danger';
    public const LVL_WARNING = 'warning';
    public const LVL_SUCCESS = 'success';
    public const LVL_INFO = 'info';
    public const LVL_PRIMARY = 'primary';

    public $text;
    public string $level;

    /**
     * @param string|Html $message
     */
    public function __construct($message, string $level)
    {
        $this->text = $message;
        $this->level = $level;
    }

    /**
     * @phpstan-return array{text:string,level:string}
     */
    public function __toArray(): array
    {
        return [
            'text' => ($this->text instanceof Html) ? $this->text->toHtml() : $this->text,
            'level' => $this->level,
        ];
    }
}
