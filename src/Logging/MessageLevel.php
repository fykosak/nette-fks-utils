<?php

declare(strict_types=1);

namespace Fykosak\Utils\Logging;

enum MessageLevel: string
{
    case Error = 'danger';
    case Warning = 'warning';
    case Success = 'success';
    case Info = 'info';
    case Primary = 'primary';
}
