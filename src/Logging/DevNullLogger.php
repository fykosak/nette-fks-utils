<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

/**
 * @phpstan-template TLang of string
 * @phpstan-implements Logger<TLang>
 */
class DevNullLogger implements Logger
{
    public function log(Message|LocalizedMessage $message): void
    {
    }
}
