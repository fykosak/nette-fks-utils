<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

use Fykosak\Utils\Components\DIComponent;

class FlashMessageDump
{
    /**
     * @phpstan-template TLang of string
     * @param MemoryLogger<TLang> $logger
     * @param DIComponent<TLang> $control
     */
    public static function dump(MemoryLogger $logger, DIComponent $control, bool $clear = true): void
    {
        foreach ($logger->getMessages() as $message) {
            $control->flashMessage($message->text, $message->level->value);
        }
        if ($clear) {
            $logger->clear();
        }
    }
}
