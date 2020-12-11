<?php

namespace Fykosak\Utils\BaseComponent;

use Fykosak\Utils\Localization\GettextTranslator;
use Nette\Application\UI\Control;
use Nette\Application\UI\ITemplate;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\DI\Container;

abstract class BaseComponent extends Control {

    protected Container $container;
    protected GettextTranslator $translator;

    public function __construct(Container $container) {
        $this->container = $container;
        $container->callInjects($this);
        $this->startUp();
    }

    protected function getContext(): Container {
        return $this->container;
    }

    public function injectTranslator(GettextTranslator $translator): void {
        $this->translator = $translator;
    }

    public function render(): void {
        $this->beforeRender();
        $this->getTemplate()->render();
    }

    protected function createTemplate(): ITemplate {
        /** @var Template $template */
        $template = parent::createTemplate();
        $template->setTranslator($this->translator);
        return $template;
    }

    protected function beforeRender(): void {
    }

    protected function startUp(): void {
    }
}
