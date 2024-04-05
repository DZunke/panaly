<?php

declare(strict_types=1);

namespace Panaly\Configuration\Exception;

use RuntimeException;
use Throwable;

class PluginLoadingFailed extends RuntimeException
{
    public static function instantiationFailed(string $class, Throwable $previous): PluginLoadingFailed
    {
        return new self(
            message: 'The plugin could not be instantiated, maybe an invalid construction?',
            previous: $previous,
        );
    }
}
