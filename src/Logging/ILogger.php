<?php

namespace Fykosak\Utils\Logging;

/**
 * Due to author's laziness there's no class doc (or it's self explaining).
 *
 * Implementations may define their own message levels.
 *
 * @author Michal Koutný <michal@fykos.cz>
 */
interface ILogger {
    public function log(Message $message): void;
}
