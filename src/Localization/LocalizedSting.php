<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

use Nette\SmartObject;

class LocalizedSting
{
    use SmartObject;

    private array $texts;

    public function __construct(?array $texts = null)
    {
        $this->texts = $texts ?? [];
    }

    public function getMessage(LangEnum & \StringBackedEnum $lang): ?string
    {
        return $this->texts[$lang->value] ?? null;
    }

    public function __toString(): string
    {
        return join('/', $this->texts);
    }
}
