<?php

declare(strict_types=1);

namespace Fykosak\Utils\Price;

class UnsupportedCurrencyException extends \Exception
{
    public function __construct(Currency $currency, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(\sprintf(_('Currency %s in not supported'), $currency->value), $code, $previous);
    }
}
