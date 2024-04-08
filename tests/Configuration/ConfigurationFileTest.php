<?php

declare(strict_types=1);

namespace Panaly\Test\Configuration;

use Panaly\Configuration\ConfigurationFile;
use Panaly\Plugin\Plugin;
use PHPUnit\Framework\TestCase;

class ConfigurationFileTest extends TestCase
{
    public function testThatAConfigurationFileCanBeCreated(): void
    {
        $plugins      = [new ConfigurationFile\Plugin(self::createStub(Plugin::class)::class)];
        $metricGroups = [new ConfigurationFile\MetricGroup('foo', 'bar', [])];
        $storage      = [new ConfigurationFile\Storage('foo', [])];
        $reporting    = [new ConfigurationFile\Reporting('bar', [])];

        $configurationFile = new ConfigurationFile($plugins, $metricGroups, $storage, $reporting);

        self::assertSame($plugins, $configurationFile->plugins);
        self::assertSame($metricGroups, $configurationFile->metricGroups);
        self::assertSame($storage, $configurationFile->storage);
        self::assertSame($reporting, $configurationFile->reporting);
    }

    public function testThatCreatingFromArrayWithoutInputIsValid(): void
    {
        $configurationFile = ConfigurationFile::fromArray([]);

        self::assertSame([], $configurationFile->plugins);
        self::assertSame([], $configurationFile->metricGroups);
        self::assertSame([], $configurationFile->storage);
        self::assertSame([], $configurationFile->reporting);
    }

    public function testThatCreatingWithPluginsButWithoutOptionsIsValid(): void
    {
        $plugin            = self::createStub(Plugin::class);
        $configurationFile = ConfigurationFile::fromArray(['plugins' => [$plugin::class => null]]);

        self::assertCount(1, $configurationFile->plugins);
        self::assertSame($plugin::class, $configurationFile->plugins[0]->class);
        self::assertSame([], $configurationFile->plugins[0]->options);
    }

    public function testThatCreatingWithPluginsWithOptionsIsValid(): void
    {
        $plugin            = self::createStub(Plugin::class);
        $configurationFile = ConfigurationFile::fromArray(['plugins' => [$plugin::class => ['foo' => 'bar']]]);

        self::assertCount(1, $configurationFile->plugins);
        self::assertSame($plugin::class, $configurationFile->plugins[0]->class);
        self::assertSame(['foo' => 'bar'], $configurationFile->plugins[0]->options);
    }

    public function testThatCreatingWithMetricGroupsIsValid(): void
    {
        $configurationFile = ConfigurationFile::fromArray(
            [
                'groups' => [
                    'foo' => [
                        'title' => 'bar',
                        'metrics' => [
                            'baz' => ['title' => 'foo_baz', 'foo' => 'bar'],
                            'quo' => ['foo' => 'baz'],
                            'also_a_baz_metric' => ['metric' => 'baz'],
                        ],
                    ],
                ],
            ],
        );

        self::assertCount(1, $configurationFile->metricGroups);
        self::assertSame('foo', $configurationFile->metricGroups[0]->identifier);
        self::assertSame('bar', $configurationFile->metricGroups[0]->title);

        self::assertCount(3, $configurationFile->metricGroups[0]->metrics);

        // The "baz" metric
        self::assertSame('foo.baz', $configurationFile->metricGroups[0]->metrics[0]->identifier);
        self::assertSame('baz', $configurationFile->metricGroups[0]->metrics[0]->metric);
        self::assertSame('foo_baz', $configurationFile->metricGroups[0]->metrics[0]->title);
        self::assertSame(['foo' => 'bar'], $configurationFile->metricGroups[0]->metrics[0]->options);

        // The "quo" metric
        self::assertSame('foo.quo', $configurationFile->metricGroups[0]->metrics[1]->identifier);
        self::assertSame('quo', $configurationFile->metricGroups[0]->metrics[1]->metric);
        self::assertNull($configurationFile->metricGroups[0]->metrics[1]->title);
        self::assertSame(['foo' => 'baz'], $configurationFile->metricGroups[0]->metrics[1]->options);

        // The "also_a_baz_metric"
        self::assertSame('also_a_baz_metric', $configurationFile->metricGroups[0]->metrics[2]->identifier);
        self::assertSame('baz', $configurationFile->metricGroups[0]->metrics[2]->metric);
    }

    public function testThatCreatingWithStorageIsValid(): void
    {
        $configurationFile = ConfigurationFile::fromArray(['storage' => ['foo' => ['foo' => 'bar']]]);

        self::assertCount(1, $configurationFile->storage);
        self::assertSame('foo', $configurationFile->storage[0]->identifier);
        self::assertSame(['foo' => 'bar'], $configurationFile->storage[0]->options);
    }

    public function testThatCreatingWithReportingIsValid(): void
    {
        $configurationFile = ConfigurationFile::fromArray(['reporting' => ['foo' => ['foo' => 'bar']]]);

        self::assertCount(1, $configurationFile->reporting);
        self::assertSame('foo', $configurationFile->reporting[0]->identifier);
        self::assertSame(['foo' => 'bar'], $configurationFile->reporting[0]->options);
    }
}
