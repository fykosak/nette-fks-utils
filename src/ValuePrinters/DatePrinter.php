<?php

declare(strict_types=1);

namespace Fykosak\Utils\ValuePrinters;

use Nette\Utils\Html;

class DatePrinter extends AbstractValuePrinter
{
    protected string $format;

    public function __construct(string $format = 'c')
    {
        $this->format = $format;
    }

    /**
     * @param \DateTimeInterface $value
     */
    protected function getHtml($value): Html
    {
        return Html::el('span')->addText($value->format($this->format));
    }
}
