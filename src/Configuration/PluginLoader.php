<?php

declare(strict_types=1);

namespace Panaly\Configuration;

use Panaly\Configuration\Exception\PluginLoadingFailed;
use Panaly\Plugin\Plugin;
use Throwable;

use function array_walk;
use function assert;

class PluginLoader
{
    public function load(ConfigurationFile $configurationFile, RuntimeConfiguration $runtimeConfiguration): void
    {
        foreach ($configurationFile->plugins as $plugin) {
            try {
                $loadedPlugin = new $plugin->class();
                assert($loadedPlugin instanceof Plugin); // Ensured by configuration validation
            } catch (Throwable $e) {
                throw PluginLoadingFailed::instantiationFailed($plugin->class, $e);
            }

            $loadedPluginMetrics = $loadedPlugin->getAvailableMetrics();
            array_walk(
                $loadedPluginMetrics,
                static fn (Plugin\Metric $metric) => $runtimeConfiguration->addMetric($metric),
            );

            $loadedPluginStorages = $loadedPlugin->getAvailableStorages();
            array_walk(
                $loadedPluginStorages,
                static fn (Plugin\Storage $storage) => $runtimeConfiguration->addStorage($storage),
            );

            $loadedPluginReports = $loadedPlugin->getAvailableReporting();
            array_walk(
                $loadedPluginReports,
                static fn (Plugin\Reporting $reporting) => $runtimeConfiguration->addReporting($reporting),
            );
        }
    }
}
