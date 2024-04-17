<?php

declare(strict_types=1);

namespace Panaly\Provider\FileProvider;

use RuntimeException;

final class InvalidFileAccess extends RuntimeException
{
    public static function fileIsADirectory(string $file): InvalidFileAccess
    {
        return new self('The provided file path "' . $file . '" is a directory.');
    }

    public static function fileNotAccessible(string $file): InvalidFileAccess
    {
        return new self('The provided file "' . $file . '" is not accessible or does not exist.');
    }

    public static function fileNotReadable(string $file): InvalidFileAccess
    {
        return new self('The provided file "' . $file . '" is not readable or does not exist.');
    }

    public static function onlyProvidedFilesAreRemovable(string $file): InvalidFileAccess
    {
        return new self('The provided file "' . $file . '" was not read by the provider and can so not be removed.');
    }
}
