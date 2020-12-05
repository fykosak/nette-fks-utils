<?php

namespace Fykosak\Utils\Logging;

use Nette\SmartObject;

/**
 * Class Message
 * @author Michal Červeňák <miso@fykos.cz>
 */
class Message {
    use SmartObject;

    public const LVL_ERROR = 'danger';
    public const LVL_WARNING = 'warning';
    public const LVL_SUCCESS = 'success';
    public const LVL_INFO = 'info';
    public const LVL_PRIMARY = 'primary';
    public const LVL_DEBUG = 'debug';

    public string $text;
    public string $level;

    public function __construct(string $message, string $level) {
        $this->text = $message;
        $this->level = $level;
    }

    public function __toArray(): array {
        return [
            'text' => $this->text,
            'message' => $this->text,
            'level' => $this->level,
        ];
    }
}
