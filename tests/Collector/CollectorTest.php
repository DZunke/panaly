<?php

declare(strict_types=1);

namespace Panaly\Test\Collector;

use Panaly\Collector\Collector;
use Panaly\Configuration\ConfigurationFileLoader;
use Panaly\Configuration\PluginLoader;
use Panaly\Configuration\RuntimeConfiguration;
use Panaly\Result\Result;
use Panaly\Test\Double\MemoryFileProvider;
use PHPUnit\Framework\TestCase;

class CollectorTest extends TestCase
{
    protected function tearDown(): void
    {
        (new MemoryFileProvider())->reset();
    }

    public function testCollectingWithoutAnyMetricsGiveEmptyResult(): void
    {
        $fixtureFile        = __DIR__ . '/../Fixtures/valid-config-without-metrics.yaml';
        $memoryFileProvider = new MemoryFileProvider();
        $memoryFileProvider->addFixture($fixtureFile);

        $collectionResult = $this->getResultFromConfigFile($memoryFileProvider, $fixtureFile);

        self::assertCount(0, $collectionResult->getGroups());
    }

    public function testCollectingMetricsWithResults(): void
    {
        $fixtureFile        = __DIR__ . '/../Fixtures/valid-config.yaml';
        $memoryFileProvider = new MemoryFileProvider();
        $memoryFileProvider->addFixture($fixtureFile);

        $collectionResult = $this->getResultFromConfigFile($memoryFileProvider, $fixtureFile);

        $groups = $collectionResult->getGroups();
        self::assertCount(1, $groups);
        self::assertSame('Foo Bar Baz', $groups[0]->getTitle());

        $metrics = $groups[0]->getMetrics();
        self::assertCount(2, $metrics);

        self::assertSame('I am a default title', $metrics[0]->title);
        self::assertSame(12, $metrics[0]->value->compute());

        self::assertSame('I am a default title', $metrics[1]->title);
        self::assertSame(12, $metrics[1]->value->compute());
    }

    private function getResultFromConfigFile(MemoryFileProvider $fileProvider, string $file): Result
    {
        $runtimeConfiguration = new RuntimeConfiguration();
        $configurationFile    = (new ConfigurationFileLoader())->loadFromFile($fileProvider, $file);
        (new PluginLoader())->load($configurationFile, $runtimeConfiguration);

        return (new Collector($configurationFile, $runtimeConfiguration))->collect();
    }
}
