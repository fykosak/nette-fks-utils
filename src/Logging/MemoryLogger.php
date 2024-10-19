<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

class MemoryLogger implements Logger
{
    /** @var Message[] */
    private array $messages = [];

    /**
     * @return Message[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function clear(): void
    {
        $this->messages = [];
    }

    public function log(Message $message): void
    {
        $this->messages[] = $message;
    }
}
