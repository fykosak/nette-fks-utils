<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

interface Logger
{
    public function log(Message $message): void;
}
