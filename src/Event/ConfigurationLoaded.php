<?php

declare(strict_types=1);

namespace Panaly\Event;

use Panaly\Configuration\ConfigurationFile;

final class ConfigurationLoaded
{
    public function __construct(
        private ConfigurationFile $configurationFile,
    ) {
    }

    public function getConfigurationFile(): ConfigurationFile
    {
        return $this->configurationFile;
    }

    public function setConfigurationFile(ConfigurationFile $configurationFile): void
    {
        $this->configurationFile = $configurationFile;
    }
}
