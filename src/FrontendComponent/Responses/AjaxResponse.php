<?php

declare(strict_types=1);

namespace Fykosak\Utils\FrontendComponent\Responses;

use Nette\Application\Response;
use Nette\Http\IRequest;
use Nette\Http\IResponse;
use Nette\SmartObject;

/**
 * @phpstan-template TData
 * @phpstan-template TLang of string
 */
final class AjaxResponse implements Response
{
    use SmartObject;

    /**
     * @phpstan-var array{
     *      messages: array{
     *          text: array<TLang,string>|string,
     *          level: string,
     *      }[],
     *      data: TData,
     *      actions: array<string,string>,
     *  } $content
     */
    private array $content;
    private int $code = IResponse::S200_OK;

    final public function getContentType(): string
    {
        return 'application/json';
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @phpstan-param  array{
     *      messages: array{
     *          text: array<TLang,string>|string,
     *          level: string,
     *      }[],
     *      data: TData,
     *      actions: array<string,string>,
     *  } $content
     */
    public function setContent(array $content): void
    {
        $this->content = $content;
    }

    public function send(IRequest $httpRequest, IResponse $httpResponse): void
    {
        $httpResponse->setCode($this->code);
        $httpResponse->setContentType($this->getContentType());
        $httpResponse->setExpiration(null);
        echo json_encode($this->content);
    }
}
