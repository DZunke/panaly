<?php

declare(strict_types=1);

namespace Panaly\Configuration\Exception;

use InvalidArgumentException;
use Panaly\Plugin\Plugin;
use Symfony\Component\Yaml\Exception\ParseException;

final class InvalidConfigurationFile extends InvalidArgumentException
{
    public static function fileNotFound(string $file): InvalidConfigurationFile
    {
        return new self('The config file "' . $file . '" is not readable or does not exists!');
    }

    public static function fileContentNotValidYaml(string $file, ParseException $e): InvalidConfigurationFile
    {
        return new self(
            message: 'The configuration file "' . $file . '" does not contain valid Yaml content.',
            previous: $e,
        );
    }

    public static function pluginClassNotExists(string $class): InvalidConfigurationFile
    {
        return new self('The plugin class "' . $class . '" does not exists.');
    }

    public static function pluginMustImplementPluginInterface(string $class): InvalidConfigurationFile
    {
        return new self(
            'The class "' . $class . '" have to implement the interface "' . Plugin::class . '" for being a plugin.',
        );
    }

    public static function reportingMustNotHaveABlankName(): InvalidConfigurationFile
    {
        return new self('A reporting configuration must have an non-empty name.');
    }

    public static function storageMustNotHaveABlankName(): InvalidConfigurationFile
    {
        return new self('A storage configuration must have an non-empty name.');
    }

    public static function metricGroupMustNotHaveABlankName(): InvalidConfigurationFile
    {
        return new self('A metric group configuration must have an non-empty name.');
    }

    public static function metricGroupMustNotHaveABlankTitle(): InvalidConfigurationFile
    {
        return new self('A metric group configuration must have an non-empty title option.');
    }

    public static function metricMustNotHaveABlankName(): InvalidConfigurationFile
    {
        return new self('A metric configuration must have an non-empty name.');
    }
}
