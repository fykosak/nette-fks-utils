<?php

declare(strict_types=1);

namespace Fykosak\Utils\Loaders;

interface StylesheetCollector
{

    /**
     * @param string $file path relative to webroot
     * @param array $media
     */
    public function registerStylesheetFile(string $file, array $media = ['all']): void;

    /**
     * @param string $file path relative to webroot
     * @param array $media
     */
    public function unregisterStylesheetFile(string $file, array $media = ['all']): void;
}
