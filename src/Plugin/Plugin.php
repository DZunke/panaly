<?php

declare(strict_types=1);

namespace Panaly\Plugin;

use Panaly\Configuration\ConfigurationFile;
use Panaly\Configuration\RuntimeConfiguration;
use Panaly\Plugin\Plugin\Metric;
use Panaly\Plugin\Plugin\Reporting;
use Panaly\Plugin\Plugin\Storage;

interface Plugin
{
    /** @param array<string, mixed> $options */
    public function initialize(
        ConfigurationFile $configurationFile,
        RuntimeConfiguration $runtimeConfiguration,
        array $options,
    ): void;

    /**
     * @param array<string, mixed> $options
     *
     * @return list<Metric>
     */
    public function getAvailableMetrics(array $options): array;

    /**
     * @param array<string, mixed> $options
     *
     * @return list<Storage>
     */
    public function getAvailableStorages(array $options): array;

    /**
     * @param array<string, mixed> $options
     *
     * @return list<Reporting>
     */
    public function getAvailableReporting(array $options): array;
}
