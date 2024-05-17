<?php

declare(strict_types=1);

namespace Panaly\Configuration;

use Panaly\Configuration\Exception\InvalidRuntimeConfiguration;
use Panaly\Plugin\Plugin;
use Panaly\Plugin\Plugin\Metric;
use Panaly\Plugin\Plugin\Reporting;
use Panaly\Plugin\Plugin\Storage;
use Panaly\Provider\FileProvider;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use function array_key_exists;
use function getcwd;

class RuntimeConfiguration
{
    private EventDispatcherInterface $eventDispatcher;
    private FileProvider $fileProvider;
    private LoggerInterface $logger;
    private string $workingDirectory;

    /** @var list<Plugin> */
    private array $loadedPlugins = [];
    /** @var array<string, Metric> */
    private array $metrics = [];
    /** @var array<string, Storage> */
    private array $storages = [];
    /** @var array<string, Reporting> */
    private array $reporting = [];

    public function __construct()
    {
        $this->eventDispatcher  = new EventDispatcher();
        $this->fileProvider     = new FileProvider();
        $this->logger           = new NullLogger();
        $this->workingDirectory = (string) getcwd();
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }

    public function getFileProvider(): FileProvider
    {
        return $this->fileProvider;
    }

    public function getWorkingDirectory(): string
    {
        return $this->workingDirectory;
    }

    public function addPlugin(Plugin $plugin): void
    {
        $this->loadedPlugins[] = $plugin;
    }

    /** @return list<Plugin> */
    public function getPlugins(): array
    {
        return $this->loadedPlugins;
    }

    public function getMetric(string $identifier): Metric
    {
        if (! $this->hasMetric($identifier)) {
            throw InvalidRuntimeConfiguration::metricNotExists($identifier);
        }

        return $this->metrics[$identifier];
    }

    public function addMetric(Metric $metric): void
    {
        if ($this->hasMetric($metric->getIdentifier())) {
            throw InvalidRuntimeConfiguration::metricAlreadyExists($metric->getIdentifier());
        }

        $this->metrics[$metric->getIdentifier()] = $metric;
    }

    public function hasMetric(string $identifier): bool
    {
        return array_key_exists($identifier, $this->metrics);
    }

    public function getStorage(string $identifier): Storage
    {
        if (! $this->hasStorage($identifier)) {
            throw InvalidRuntimeConfiguration::storageNotExists($identifier);
        }

        return $this->storages[$identifier];
    }

    public function addStorage(Storage $storage): void
    {
        if ($this->hasStorage($storage->getIdentifier())) {
            throw InvalidRuntimeConfiguration::storageAlreadyExists($storage->getIdentifier());
        }

        $this->storages[$storage->getIdentifier()] = $storage;
    }

    public function hasStorage(string $identifier): bool
    {
        return array_key_exists($identifier, $this->storages);
    }

    public function getReporting(string $identifier): Reporting
    {
        if (! $this->hasReporting($identifier)) {
            throw InvalidRuntimeConfiguration::reportingNotExists($identifier);
        }

        return $this->reporting[$identifier];
    }

    public function addReporting(Reporting $reporting): void
    {
        if ($this->hasReporting($reporting->getIdentifier())) {
            throw InvalidRuntimeConfiguration::reportingAlreadyExists($reporting->getIdentifier());
        }

        $this->reporting[$reporting->getIdentifier()] = $reporting;
    }

    public function hasReporting(string $identifier): bool
    {
        return array_key_exists($identifier, $this->reporting);
    }
}
