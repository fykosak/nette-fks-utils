<?php

declare(strict_types=1);

namespace Fykosak\Utils\DateTime;

enum Period
{
    case before;
    case after;
    case onGoing;
}
