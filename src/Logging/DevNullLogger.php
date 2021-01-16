<?php

namespace Fykosak\Utils\Logging;

/**
 * Due to author's laziness there's no class doc (or it's self explaining).
 *
 * @author Michal Koutný <michal@fykos.cz>
 */
class DevNullLogger implements Logger {

    public function log(Message $message): void {
        /* empty */
    }
}
