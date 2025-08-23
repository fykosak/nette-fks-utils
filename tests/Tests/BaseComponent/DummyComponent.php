<?php

declare(strict_types=1);

namespace Fykosak\Utils\Tests\BaseComponent;

use Fykosak\Utils\Components\DIComponent;
use Fykosak\Utils\Tests\DummyService;

/**
 * @phpstan-template TLang of string
 * @phpstan-extends DIComponent<TLang>
 */
class DummyComponent extends DIComponent
{
    public DummyService $dummyService;

    public function injectDummy(DummyService $dummyService): void
    {
        $this->dummyService = $dummyService;
    }

    public function render(): void
    {
        //$this->flashMessage('test string', 'error');
        $this->template->render(__DIR__ . '/layout.latte');
    }

}
