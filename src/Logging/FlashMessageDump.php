<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

use Nette\Application\UI\Control;

class FlashMessageDump
{
    /**
     * @phpstan-template TLang of string
     * @param MemoryLogger<TLang> $logger
     */
    public static function dump(MemoryLogger $logger, Control $control, bool $clear = true): void
    {
        foreach ($logger->getMessages() as $message) {
            $control->flashMessage($message->text, $message->level->value);
        }
        if ($clear) {
            $logger->clear();
        }
    }
}
