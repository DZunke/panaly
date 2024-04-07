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
    /**
     * The method is called to give a plugin the possibility to do something with the configuration file and runtime
     * configuration on loading. Enables, for example, access to the event dispatcher which is given in the runtime
     * configuration and so allows to register listeners or subscriber to it.
     */
    public function initialize(ConfigurationFile $configurationFile, RuntimeConfiguration $runtimeConfiguration): void;

    /** @return list<Metric> */
    public function getAvailableMetrics(): array;

    /** @return list<Storage> */
    public function getAvailableStorages(): array;

    /** @return list<Reporting> */
    public function getAvailableReporting(): array;
}
