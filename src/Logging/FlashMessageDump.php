<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

use Nette\Application\UI\Control;

class FlashMessageDump
{

    public static function dump(Logger $logger, Control $control, bool $clear = true): void
    {
        if ($logger instanceof MemoryLogger) {
            foreach ($logger->getMessages() as $message) {
                $control->flashMessage($message->text, $message->level);
            }
            if ($clear) {
                $logger->clear();
            }
        }
    }
}
