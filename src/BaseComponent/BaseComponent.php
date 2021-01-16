<?php

namespace Fykosak\Utils\BaseComponent;

use Fykosak\Utils\Localization\GettextTranslator;
use Nette\Application\UI\Control;
use Nette\Application\UI\Template;
use Nette\DI\Container;

abstract class BaseComponent extends Control {

    protected Container $container;
    protected GettextTranslator $translator;

    public function __construct(Container $container) {
        $this->container = $container;
        $container->callInjects($this);
    }

    protected function getContext(): Container {
        return $this->container;
    }

    public function injectTranslator(GettextTranslator $translator): void {
        $this->translator = $translator;
    }

    protected function createTemplate(): Template {
        $template = parent::createTemplate();
        $template->setTranslator($this->translator);
        return $template;
    }
}
