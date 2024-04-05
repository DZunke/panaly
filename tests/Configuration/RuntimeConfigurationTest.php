<?php

declare(strict_types=1);

namespace Panaly\Test\Configuration;

use Panaly\Configuration\Exception\InvalidRuntimeConfiguration;
use Panaly\Configuration\RuntimeConfiguration;
use Panaly\Plugin\Plugin\Metric;
use Panaly\Plugin\Plugin\Reporting;
use Panaly\Plugin\Plugin\Storage;
use PHPUnit\Framework\TestCase;

class RuntimeConfigurationTest extends TestCase
{
    public function testThatAddingMetricIsWorking(): void
    {
        $metric = self::createStub(Metric::class);
        $metric->method('getIdentifier')->willReturn('foo');

        $configuration = new RuntimeConfiguration();
        $configuration->addMetric($metric);

        self::assertTrue($configuration->hasMetric('foo'));
        self::assertSame($metric, $configuration->getMetric('foo'));
    }

    public function testGettingANonExistingMetricThrowsAnException(): void
    {
        $this->expectException(InvalidRuntimeConfiguration::class);
        $this->expectExceptionMessage('A metric with the name "foo" does not exists in runtime.');

        $configuration = new RuntimeConfiguration();
        $configuration->getMetric('foo');
    }

    public function testThatAddingAPluginWithSameIdentifierWillFail(): void
    {
        $this->expectException(InvalidRuntimeConfiguration::class);
        $this->expectExceptionMessage('A metric with the name "foo" already exists in runtime.');

        $metric = self::createStub(Metric::class);
        $metric->method('getIdentifier')->willReturn('foo');

        $duplicateMetric = self::createStub(Metric::class);
        $duplicateMetric->method('getIdentifier')->willReturn('foo');

        $configuration = new RuntimeConfiguration();
        $configuration->addMetric($metric);
        $configuration->addMetric($duplicateMetric);
    }

    public function testThatAddingStorageIsWorking(): void
    {
        $storage = self::createStub(Storage::class);
        $storage->method('getIdentifier')->willReturn('foo');

        $configuration = new RuntimeConfiguration();
        $configuration->addStorage($storage);

        self::assertTrue($configuration->hasStorage('foo'));
        self::assertSame($storage, $configuration->getStorage('foo'));
    }

    public function testGettingANonExistingStorageThrowsAnException(): void
    {
        $this->expectException(InvalidRuntimeConfiguration::class);
        $this->expectExceptionMessage('A storage with the name "foo" does not exists in runtime.');

        $configuration = new RuntimeConfiguration();
        $configuration->getStorage('foo');
    }

    public function testThatAddingAStorageWithSameIdentifierWillFail(): void
    {
        $this->expectException(InvalidRuntimeConfiguration::class);
        $this->expectExceptionMessage('A storage with the name "foo" already exists in runtime.');

        $storage = self::createStub(Storage::class);
        $storage->method('getIdentifier')->willReturn('foo');

        $duplicateStorage = self::createStub(Storage::class);
        $duplicateStorage->method('getIdentifier')->willReturn('foo');

        $configuration = new RuntimeConfiguration();
        $configuration->addStorage($storage);
        $configuration->addStorage($duplicateStorage);
    }

    public function testThatAddingReportingIsWorking(): void
    {
        $reporting = self::createStub(Reporting::class);
        $reporting->method('getIdentifier')->willReturn('foo');

        $configuration = new RuntimeConfiguration();
        $configuration->addReporting($reporting);

        self::assertTrue($configuration->hasReporting('foo'));
        self::assertSame($reporting, $configuration->getReporting('foo'));
    }

    public function testThatAddingAReportWithSameIdentifierWillFail(): void
    {
        $this->expectException(InvalidRuntimeConfiguration::class);
        $this->expectExceptionMessage('A reporting with the name "foo" already exists in runtime.');

        $reporting = self::createStub(Reporting::class);
        $reporting->method('getIdentifier')->willReturn('foo');

        $duplicateReporting = self::createStub(Reporting::class);
        $duplicateReporting->method('getIdentifier')->willReturn('foo');

        $configuration = new RuntimeConfiguration();
        $configuration->addReporting($reporting);
        $configuration->addReporting($duplicateReporting);
    }

    public function testGettingANonExistingReportingThrowsAnException(): void
    {
        $this->expectException(InvalidRuntimeConfiguration::class);
        $this->expectExceptionMessage('A reporting with the name "foo" does not exists in runtime.');

        $configuration = new RuntimeConfiguration();
        $configuration->getReporting('foo');
    }
}
