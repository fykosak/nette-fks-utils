<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

enum MessageLevel: string
{
    case ERROR = 'danger';
    case WARNING = 'warning';
    case SUCCESS = 'success';
    case INFO = 'info';
    case PRIMARY = 'primary';
}
