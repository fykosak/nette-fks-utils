<?php

declare(strict_types=1);

namespace Fykosak\Utils\FrontendComponent\Components;

use Fykosak\Utils\FrontendComponent\NetteActions\NetteActions;
use Fykosak\Utils\FrontendComponent\Responses\AjaxResponse;
use Fykosak\Utils\Logging\Message;
use Nette\Application\AbortException;
use Nette\Application\UI\InvalidLinkException;
use Nette\DI\Container;
use Nette\Http\IRequest;
use Nette\Http\IResponse;

abstract class AjaxComponent extends FrontEndComponent
{
    private IRequest $request;
    protected NetteActions $actions;

    public function __construct(Container $container, string $frontendId)
    {
        parent::__construct($container, $frontendId);
        $this->actions = new NetteActions($this);
    }

    final public function injectRequest(IRequest $request): void
    {
        $this->request = $request;
    }

    /**
     * @throws InvalidLinkException
     */
    final public function addAction(string $key, string $destination, array $params = []): void
    {
        $this->actions->addAction($key, $destination, $params);
    }
    /**
     * @throws InvalidLinkException
     */
    final public function addPresenterLink(string $key, string $destination, array $params = []): void
    {
        $this->actions->addPresenterLink($key, $destination, $params);
    }

    protected function getAjaxData(): mixed
    {
        return $this->getData();
    }

    protected function getAjaxResponseData(): array
    {
        $this->configure();
        $data = [
            'messages' => array_map(
                fn(Message $value): array => $value->__toArray(),
                $this->getLogger()->getMessages()
            ),
            'data' => $this->getAjaxData(),
            'actions' => $this->actions->getActions(),
        ];
        $this->getLogger()->clear();
        return $data;
    }

    /**
     * @throws AbortException
     */
    final protected function sendAjaxResponse(int $code = IResponse::S200_OK): void
    {
        $response = new AjaxResponse();
        $response->setCode($code);
        $response->setContent($this->getAjaxResponseData());
        $this->getPresenter()->sendResponse($response);
    }

    final protected function getHttpRequest(): IRequest
    {
        return $this->request;
    }

    protected function getResponseData(): array
    {
        $data = parent::getResponseData();
        $data['actions'] = $this->actions->getActions();
        return $data;
    }
}
