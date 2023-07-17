<?php

declare(strict_types=1);

namespace Fykosak\Utils\Localization;

class LocalizedString
{
    private array $texts;

    public function __construct(array $texts)
    {
        $this->texts = $texts;
    }

    public function __get(string $lang): ?string
    {
        return $this->getText($lang);
    }

    public function getText(string $lang): ?string
    {
        return $this->texts[$lang] ?? null;
    }

    public function __serialize(): array
    {
        return $this->texts;
    }

    public function __toString(): string
    {
        return join('/', $this->texts);
    }
}
