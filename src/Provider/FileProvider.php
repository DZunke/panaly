<?php

declare(strict_types=1);

namespace Panaly\Provider;

use Panaly\Provider\FileProvider\InvalidFileAccess;

use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function is_dir;
use function is_readable;
use function unlink;

/**
 * The class delivers a centralized toolset to work with files. Through the Runtime it will also be available
 * to plugins to be utilized  - but because of a static storage it can also be instantiated as often as needed.
 * A centralized usage can be beneficial to a longer running job with identical files opened by multiple methods.
 * In this case every running process would access the filesystem and bring a file to the memory while this could
 * be done once.
 * It has to be ensured that during the process read and write should be handled with this process because the write
 * process will overwrite the cached content which would otherwise be invalid.
 * Another advantage of this provider class is that the error handling is centralized and must not be implement again
 * and again.
 */
class FileProvider
{
    /** @var array<string, string> */
    protected static array $files = [];

    public function read(string $path): string
    {
        if (isset(self::$files[$path])) {
            return self::$files[$path];
        }

        if ($this->isDirectory($path)) {
            throw InvalidFileAccess::fileIsADirectory($path);
        }

        if (! $this->isFile($path)) {
            throw InvalidFileAccess::fileNotAccessible($path);
        }

        $fileContent = @file_get_contents($path);
        if ($fileContent === false) {
            throw InvalidFileAccess::fileNotReadable($path);
        }

        return self::$files[$path] = $fileContent;
    }

    public function write(string $path, string $content): void
    {
        self::$files[$path] = $content;

        file_put_contents($path, $content);
    }

    public function remove(string $path): void
    {
        if (! isset(self::$files[$path])) {
            throw InvalidFileAccess::onlyProvidedFilesAreRemovable($path);
        }

        unset(self::$files[$path]);
        @unlink($path);
    }

    public function isFile(string $path): bool
    {
        return file_exists($path) && is_readable($path);
    }

    public function isDirectory(string $path): bool
    {
        return is_dir($path) && is_readable($path);
    }
}
