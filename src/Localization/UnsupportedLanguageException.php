<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

use Nette\Http\IResponse;
use Throwable;

class UnsupportedLanguageException extends \Exception
{
    public function __construct(string $lang, ?Throwable $previous = null)
    {
        parent::__construct(sprintf(_('Language %s is not supported'), $lang), IResponse::S400_BAD_REQUEST, $previous);
    }
}
