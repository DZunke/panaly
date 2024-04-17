<?php

declare(strict_types=1);

namespace Panaly\Test\Double;

use Panaly\Provider\FileProvider;

use function array_key_exists;
use function file_exists;
use function file_get_contents;

class MemoryFileProvider extends FileProvider
{
    public function write(string $path, string $content): void
    {
        self::$files[$path] = $content;
    }

    public function remove(string $path): void
    {
        unset(self::$files[$path]);
    }

    public function isFile(string $path): bool
    {
        return array_key_exists($path, self::$files);
    }

    public function isDirectory(string $path): bool
    {
        return false;
    }

    public function addFixture(string $file, string|null $content = null): void
    {
        if ($content === null && file_exists($file)) {
            self::$files[$file] = (string) file_get_contents($file);

            return;
        }

        self::$files[$file] = $content ?? '';
    }

    public function reset(): void
    {
        self::$files = [];
    }
}
