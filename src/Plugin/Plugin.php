<?php

declare(strict_types=1);

namespace Panaly\Plugin;

use Panaly\Configuration\ConfigurationFile;
use Panaly\Configuration\RuntimeConfiguration;

interface Plugin
{
    /** @param array<string, mixed> $options */
    public function initialize(
        ConfigurationFile $configurationFile,
        RuntimeConfiguration $runtimeConfiguration,
        array $options,
    ): void;
}
