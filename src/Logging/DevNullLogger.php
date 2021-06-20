<?php

namespace Fykosak\Utils\Logging;

class DevNullLogger implements Logger {

    public function log(Message $message): void {
        /* empty */
    }
}
