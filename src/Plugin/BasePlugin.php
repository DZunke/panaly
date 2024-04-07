<?php

declare(strict_types=1);

namespace Panaly\Plugin;

use Panaly\Configuration\ConfigurationFile;
use Panaly\Configuration\RuntimeConfiguration;
use Panaly\Plugin\Plugin\Metric;
use Panaly\Plugin\Plugin\Reporting;
use Panaly\Plugin\Plugin\Storage;

abstract class BasePlugin implements Plugin
{
    public function initialize(ConfigurationFile $configurationFile, RuntimeConfiguration $runtimeConfiguration): void
    {
        // Do nothing by design ... it just has to be overwritten when there is something to do
        // Idea: Maybe allow also a plugin configuration that could be given here in the future?
    }

    /** @return list<Metric> */
    public function getAvailableMetrics(): array
    {
        return [];
    }

    /** @return list<Storage> */
    public function getAvailableStorages(): array
    {
        return [];
    }

    /** @return list<Reporting> */
    public function getAvailableReporting(): array
    {
        return [];
    }
}
