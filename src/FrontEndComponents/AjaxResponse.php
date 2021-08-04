<?php

declare(strict_types=1);

namespace Fykosak\Utils\FrontEndComponents;

use Nette\Http\IRequest;
use Nette\Http\Response;
use Nette\SmartObject;

final class AjaxResponse implements \Nette\Application\Response
{
    use SmartObject;

    private array $content = [];
    private int $code = Response::S200_OK;

    final public function getContentType(): string
    {
        return 'application/json';
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function setContent(array $content): void
    {
        $this->content = $content;
    }

    public function send(IRequest $httpRequest, \Nette\Http\IResponse $httpResponse): void
    {
        $httpResponse->setCode($this->code);
        $httpResponse->setContentType($this->getContentType());
        $httpResponse->setExpiration(false);
        echo json_encode($this->content);
    }
}
