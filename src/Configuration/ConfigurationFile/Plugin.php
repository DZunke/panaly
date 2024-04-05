<?php

declare(strict_types=1);

namespace Panaly\Configuration\ConfigurationFile;

use Panaly\Configuration\Exception\InvalidConfigurationFile;
use Panaly\Plugin\Plugin as PluginInterface;

use function class_exists;
use function is_a;

readonly class Plugin
{
    /** @param class-string $class */
    public function __construct(
        public string $class,
    ) {
        if (! class_exists($this->class)) {
            throw InvalidConfigurationFile::pluginClassNotExists($this->class);
        }

        if (! is_a($this->class, PluginInterface::class, true)) {
            throw InvalidConfigurationFile::pluginMustImplementPluginInterface($this->class);
        }
    }
}
