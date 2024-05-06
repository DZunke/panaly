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
                $runtimeConfiguration->getLogger()->debug('Plugin "' . $plugin->class . '" loading.');
                $loadedPlugin = new $plugin->class();
                assert($loadedPlugin instanceof Plugin); // Ensured by configuration validation
            } catch (Throwable $e) {
                throw PluginLoadingFailed::instantiationFailed($plugin->class, $e);
            }

            $loadedPlugin->initialize($configurationFile, $runtimeConfiguration, $plugin->options);
            $runtimeConfiguration->getLogger()->debug('Plugin "' . $plugin->class . '" initialized.', $plugin->options);

            $loadedPluginMetrics = $loadedPlugin->getAvailableMetrics($plugin->options);
            array_walk(
                $loadedPluginMetrics,
                static fn (Plugin\Metric $metric) => $runtimeConfiguration->addMetric($metric),
            );

            $loadedPluginStorages = $loadedPlugin->getAvailableStorages($plugin->options);
            array_walk(
                $loadedPluginStorages,
                static fn (Plugin\Storage $storage) => $runtimeConfiguration->addStorage($storage),
            );

            $loadedPluginReports = $loadedPlugin->getAvailableReporting($plugin->options);
            array_walk(
                $loadedPluginReports,
                static fn (Plugin\Reporting $reporting) => $runtimeConfiguration->addReporting($reporting),
            );

            $runtimeConfiguration->addPlugin($loadedPlugin);
        }
    }
}
