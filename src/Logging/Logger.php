<?php

namespace Fykosak\Utils\Logging;

/**
 * Due to author's laziness there's no class doc (or it's self explaining).
 *
 * Implementations may define their own message levels.
 *
 * @author Michal Koutný <michal@fykos.cz>
 * @author Michal Červeňák <miso@fykos.cz>
 */
interface Logger {
    public function log(Message $message): void;
}
