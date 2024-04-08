<?php

declare(strict_types=1);

namespace Panaly\Plugin;

use Panaly\Configuration\ConfigurationFile;
use Panaly\Configuration\RuntimeConfiguration;

abstract class BasePlugin implements Plugin
{
    public function initialize(
        ConfigurationFile $configurationFile,
        RuntimeConfiguration $runtimeConfiguration,
        array $options,
    ): void {
    }

    /** @inheritDoc */
    public function getAvailableMetrics(array $options): array
    {
        return [];
    }

    /** @inheritDoc */
    public function getAvailableStorages(array $options): array
    {
        return [];
    }

    /** @inheritDoc */
    public function getAvailableReporting(array $options): array
    {
        return [];
    }
}
