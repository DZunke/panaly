<?php

declare(strict_types=1);

namespace Panaly\Configuration;

use Panaly\Configuration\Exception\PluginLoadingFailed;
use Panaly\Plugin\Plugin;
use Throwable;

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

            $runtimeConfiguration->addPlugin($loadedPlugin);

            $loadedPlugin->initialize($configurationFile, $runtimeConfiguration, $plugin->options);
            $runtimeConfiguration->getLogger()->debug('Plugin "' . $plugin->class . '" initialized.', $plugin->options);
        }
    }
}
