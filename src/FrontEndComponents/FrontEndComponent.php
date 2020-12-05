<?php

namespace Fykosak\Utils\FrontEndComponents;

use Fykosak\Utils\BaseComponent\BaseComponent;
use Nette\DI\Container;
use Nette\Utils\Html;

/**
 * Class FrontEndComponent
 * @author Michal Červeňák <miso@fykos.cz>
 */
abstract class FrontEndComponent extends BaseComponent {
    use FrontEndComponentTrait;

    public function __construct(Container $container, string $reactId) {
        parent::__construct($container);
        $this->registerReact($reactId);
    }

    final public function render(): void {
        $html = Html::el('div');
        $this->appendPropertyTo($html);
        $this->template->html = $html;
        $this->template->setFile(__DIR__ . DIRECTORY_SEPARATOR . 'layout.latte');
        $this->template->render();
    }
}
