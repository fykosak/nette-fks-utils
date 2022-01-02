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

    public function __get(string $lang): ?string
    {
        return $this->texts[$lang] ?? null;
    }

    public function __set(string $lang, string $text): void
    {
        $this->texts[$lang] = $text;
    }

    public function __toString(): string
    {
        return join('/', $this->texts);
    }
}
