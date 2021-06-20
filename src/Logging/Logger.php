<?php

namespace Fykosak\Utils\Logging;

interface Logger {
    public function log(Message $message): void;
}
