<?php

declare(strict_types=1);

namespace Panaly\Configuration;

use Panaly\Configuration\ConfigurationFile\Metric;
use Panaly\Configuration\ConfigurationFile\MetricGroup;
use Panaly\Configuration\ConfigurationFile\Plugin;
use Panaly\Configuration\ConfigurationFile\Reporting;
use Panaly\Configuration\ConfigurationFile\Storage;

use function array_key_exists;
use function array_map;

readonly class ConfigurationFile
{
    /**
     * @param list<Plugin>      $plugins
     * @param list<MetricGroup> $metricGroups
     * @param list<Storage>     $storage
     * @param list<Reporting>   $reporting
     */
    public function __construct(
        public array $plugins,
        public array $metricGroups,
        public array $storage,
        public array $reporting,
    ) {
    }

    public static function fromArray(array $config): ConfigurationFile
    {
        return new self(
            self::buildPluginConfig($config['plugins'] ?? []),
            self::buildMetricGroupConfig($config['groups'] ?? []),
            self::buildStorageConfig($config['storage'] ?? []),
            self::buildReportingConfig($config['reporting'] ?? []),
        );
    }

    /**
     * @param list<class-string> $pluginConfig
     *
     * @return list<Plugin>
     */
    private static function buildPluginConfig(array $pluginConfig): array
    {
        return array_map(
            static fn (string $class) => new Plugin($class),
            $pluginConfig,
        );
    }

    /**
     * @param array<string, array|null> $reportingConfig
     *
     * @return list<Reporting>
     */
    private static function buildReportingConfig(array $reportingConfig): array
    {
        $reporting = [];
        foreach ($reportingConfig as $identifier => $options) {
            $reporting[] = new Reporting($identifier, $options ?? []);
        }

        return $reporting;
    }

    /**
     * @param array<string, array|null> $storageConfig
     *
     * @return list<Storage>
     */
    private static function buildStorageConfig(array $storageConfig): array
    {
        $storage = [];
        foreach ($storageConfig as $identifier => $options) {
            $storage[] = new Storage($identifier, $options ?? []);
        }

        return $storage;
    }

    /**
     * @param array<string, array|null> $metricGroupConfig
     *
     * @return list<MetricGroup>
     */
    private static function buildMetricGroupConfig(array $metricGroupConfig): array
    {
        $metricGroup = [];
        foreach ($metricGroupConfig as $groupIdentifier => $options) {
            $metricGroup[] = new MetricGroup(
                $groupIdentifier,
                $options['title'] ?? '',
                self::convertToMetricConfig($options['metrics'] ?? []),
            );
        }

        return $metricGroup;
    }

    /**
     * @param array<string, array|null> $metricConfig
     *
     * @return list<Metric>
     */
    private static function convertToMetricConfig(array $metricConfig): array
    {
        $metrics = [];
        foreach ($metricConfig as $identifier => $options) {
            $title = $options['title'] ?? null;

            $options ??= [];
            unset($options['title']);

            if (array_key_exists('metric', $options)) {
                // Take the metric not from the key but from the option
                $identifier = $options['metric'];
                unset($options['metric']);
            }

            $metrics[] = new Metric($identifier, $title, $options);
        }

        return $metrics;
    }
}
