<?php

namespace Fykosak\Utils\Logging;

/**
 * Due to author's laziness there's no class doc (or it's self explaining).
 *
 * @author Michal Koutný <michal@fykos.cz>
 */
class MemoryLogger implements ILogger {

    private array $messages = [];

    /**
     * @return Message[]
     */
    public function getMessages(): array {
        return $this->messages;
    }

    public function clear(): void {
        $this->messages = [];
    }

    public function log(Message $message): void {
        $this->messages[] = $message;
    }
}
