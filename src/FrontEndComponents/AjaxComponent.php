<?php

namespace Fykosak\Utils\FrontEndComponents;

use Nette\Application\AbortException;
use Nette\Application\UI\InvalidLinkException;
use Nette\DI\Container;
use Nette\Http\{Response, IRequest};

abstract class AjaxComponent extends FrontEndComponent {

    private IRequest $request;
    protected NetteActions $actions;

    public function __construct(Container $container, string $reactId) {
        parent::__construct($container, $reactId);
        $this->actions = new NetteActions($this);
    }

    final public function injectRequest(IRequest $request): void {
        $this->request = $request;
    }

    /**
     * @param string $key
     * @param string $destination
     * @param array $params
     * @throws InvalidLinkException
     */
    public function addAction(string $key, string $destination, array $params = []): void {
        $this->actions->addAction($key, $destination, $params);
    }

    /**
     * @param int $code
     * @return void
     * @throws AbortException
     */
    protected function sendAjaxResponse(int $code = Response::S200_OK): void {
        $response = new AjaxResponse();
        $response->setCode($code);
        $response->setContent($this->getResponseData());
        $this->getPresenter()->sendResponse($response);
    }

    protected function getHttpRequest(): IRequest {
        return $this->request;
    }

    protected function getResponseData(): array {
        $data = parent::getResponseData();
        $data['actions'] = $this->actions->serialize();
        return $data;
    }
}
