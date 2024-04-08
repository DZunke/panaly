<?php

declare(strict_types=1);

namespace Panaly\Configuration\ConfigurationFile;

use Panaly\Configuration\Exception\InvalidConfigurationFile;
use Panaly\Plugin\Plugin as PluginInterface;

use function class_exists;
use function is_a;

class Plugin
{
    /**
     * @param class-string         $class
     * @param array<string, mixed> $options
     */
    public function __construct(
        public readonly string $class,
        public readonly array $options = [],
    ) {
        if (! class_exists($this->class)) {
            throw InvalidConfigurationFile::pluginClassNotExists($this->class);
        }

        if (! is_a($this->class, PluginInterface::class, true)) {
            throw InvalidConfigurationFile::pluginMustImplementPluginInterface($this->class);
        }
    }
}
