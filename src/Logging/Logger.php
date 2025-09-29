<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

/**
 * @phpstan-template TLang of string = string
 */
interface Logger
{
    /**
     * @phpstan-param Message|LocalizedMessage<TLang> $message
     */
    public function log(Message|LocalizedMessage $message): void;
}
