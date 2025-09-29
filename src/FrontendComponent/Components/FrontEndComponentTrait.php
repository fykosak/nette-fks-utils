<?php

declare(strict_types=1);

namespace Fykosak\Utils\FrontendComponent\Components;

use Fykosak\Utils\Logging\LocalizedMessage;
use Fykosak\Utils\Logging\MemoryLogger;
use Fykosak\Utils\Logging\Message;
use Nette\Application\BadRequestException;
use Nette\Forms\Controls\BaseControl;
use Nette\Utils\Html;

/**
 * @phpstan-template TData of mixed
 * @phpstan-template TLang of string
 */
trait FrontEndComponentTrait
{
    private string $frontendId;

    protected function registerFrontend(string $frontendId): void
    {
        $this->frontendId = $frontendId;
    }

    /**
     * @throws BadRequestException
     */
    protected function appendProperty(): void
    {
        if (!$this instanceof BaseControl) {
            throw new BadRequestException('method appendProperty can be used only with BaseControl');
        }
        $this->appendPropertyTo($this->control);
    }

    protected function appendPropertyTo(Html $html): void
    {
        $html->setAttribute('data-frontend-root', true);
        $html->setAttribute('data-frontend-id', $this->frontendId);
        foreach ($this->getResponseData() as $key => $value) {
            $html->setAttribute('data-' . $key, json_encode($value));
        }
    }

    /**
     * @phpstan-return MemoryLogger<TLang>
     */
    protected function getLogger(): MemoryLogger
    {
        /** @var MemoryLogger|null $logger */
        static $logger;
        if (!isset($logger)) {
            $logger = new MemoryLogger();
        }
        return $logger;
    }

    /**
     * @phpstan-return TData
     */
    abstract protected function getData(): mixed;

    protected function configure(): void
    {
    }

    /**
     * @phpstan-return array{
     *      messages: array{
     *          text: string|array<TLang,string>,
     *          level: string,
     *      }[],
     *      data: TData,
     *  }
     */
    protected function getResponseData(): array
    {
        $this->configure();
        $data = [
            'messages' => array_map(
                fn(Message|LocalizedMessage $value): array => $value->__toArray(),
                $this->getLogger()->getMessages()
            ),
            'data' => $this->getData(),
        ];
        $this->getLogger()->clear();
        return $data;
    }
}
