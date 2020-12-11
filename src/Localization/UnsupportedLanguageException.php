<?php

namespace Fykosak\Utils\Localization;

use Nette\Application\BadRequestException;
use Nette\Http\IResponse;
use Throwable;

/**
 * Class UnsupportedLanguageException
 * @author Michal Červeňák <miso@fykos.cz>
 */
class UnsupportedLanguageException extends BadRequestException {
    public function __construct(string $lang, ?Throwable $previous = null) {
        parent::__construct(sprintf(_('Language %s is not supported'), $lang), IResponse::S400_BAD_REQUEST, $previous);
    }
}
