<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

/**
 * @phpstan-template TLang of string = string
 * @phpstan-implements Logger<TLang>
 */
class MemoryLogger implements Logger
{
    /** @var (Message|LocalizedMessage<TLang>)[] */
    private array $messages = [];

    /**
     * @return (Message|LocalizedMessage<TLang>)[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function clear(): void
    {
        $this->messages = [];
    }

    /**
     * @phpstan-param Message|LocalizedMessage<TLang> $message
     */
    public function log(Message|LocalizedMessage $message): void
    {
        $this->messages[] = $message;
    }
}
