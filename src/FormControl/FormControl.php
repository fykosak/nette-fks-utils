<?php

declare(strict_types=1);

namespace Fykosak\Utils\FormControl;

use Fykosak\Utils\Components\DIComponent;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\BaseControl;

/**
 * Bootstrap compatible form control with support for AJAX in terms
 * of form/container groups.
 * @phpstan-extends DIComponent<'cs'|'en'>
 */
class FormControl extends DIComponent
{
    protected function createComponentForm(): Form
    {
        return new Form();
    }

    final public function getForm(): Form
    {
        /** @var Form $component */
        $component = $this->getComponent('form');
        return $component;
    }

    final public function render(): void
    {
        if (!isset($this->template->mainContainer)) {
            /** @phpstan-ignore property.notFound  */
            $this->template->form = $this->getComponent('form');
        }
        $this->template->render(__DIR__ . DIRECTORY_SEPARATOR . 'layout.containers.latte');
    }

    /**
     * @phpstan-return array{class:string,id:string}
     */
    public static function buildContainerAttributes(BaseControl $control, ?string $class = null): array
    {
        return [
            'class' => ($class ?? 'form-group') . ' mb-3'
                . ($control->hasErrors() ? ' has-error has-validation ' : ' ')
                . ($control->isRequired() ? 'required' : ''),
            'id' => $control->getHtmlId() . '-pair',
        ];
    }
}
