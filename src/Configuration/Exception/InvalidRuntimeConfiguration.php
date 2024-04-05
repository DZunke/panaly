<?php

declare(strict_types=1);

namespace Panaly\Configuration\Exception;

use InvalidArgumentException;

class InvalidRuntimeConfiguration extends InvalidArgumentException
{
    public static function metricAlreadyExists(string $identifier): InvalidRuntimeConfiguration
    {
        return new self('A metric with the name "' . $identifier . '" already exists in runtime.');
    }

    public static function metricNotExists(string $identifier): InvalidRuntimeConfiguration
    {
        return new self('A metric with the name "' . $identifier . '" does not exists in runtime.');
    }

    public static function storageAlreadyExists(string $identifier): InvalidRuntimeConfiguration
    {
        return new self('A storage with the name "' . $identifier . '" already exists in runtime.');
    }

    public static function storageNotExists(string $identifier): InvalidRuntimeConfiguration
    {
        return new self('A storage with the name "' . $identifier . '" does not exists in runtime.');
    }

    public static function reportingAlreadyExists(string $identifier): InvalidRuntimeConfiguration
    {
        return new self('A reporting with the name "' . $identifier . '" already exists in runtime.');
    }

    public static function reportingNotExists(string $identifier): InvalidRuntimeConfiguration
    {
        return new self('A reporting with the name "' . $identifier . '" does not exists in runtime.');
    }
}
