<?php

declare(strict_types=1);

namespace Panaly\Test\Configuration;

use Panaly\Configuration\ConfigurationFileLoader;
use Panaly\Configuration\Exception\InvalidConfigurationFile;
use Panaly\Provider\FileProvider;
use Panaly\Test\Double\MemoryFileProvider;
use Panaly\Test\Fixtures\Plugin\TestPlugin;
use PHPUnit\Framework\TestCase;

class ConfigurationFileLoaderTest extends TestCase
{
    protected function tearDown(): void
    {
        (new MemoryFileProvider())->reset();
    }

    public function testThatLoadingANonExistingFileWillNotWork(): void
    {
        $this->expectException(FileProvider\InvalidFileAccess::class);
        $this->expectExceptionMessage('The provided file "not-existing-yet.yml" is not accessible or does not exist.');

        $loader = new ConfigurationFileLoader();
        $loader->loadFromFile(new MemoryFileProvider(), 'not-existing-yet.yml');
    }

    public function testThatLoadingAnInvalidConfigurationFileWillThrowAnException(): void
    {
        $memoryFileProvider = new MemoryFileProvider();

        $file = __DIR__ . '/../Fixtures/invalid-config.yaml';
        $memoryFileProvider->addFixture($file);

        $this->expectException(InvalidConfigurationFile::class);
        $this->expectExceptionMessage('The configuration file "' . $file . '" does not contain valid Yaml content.');

        $loader = new ConfigurationFileLoader();
        $loader->loadFromFile($memoryFileProvider, $file);
    }

    public function testThatLoadingAValidConfigurationFileWillWork(): void
    {
        $validConfigFile = __DIR__ . '/../Fixtures/valid-config.yaml';

        $memoryFileProvider = new MemoryFileProvider();
        $memoryFileProvider->addFixture($validConfigFile);

        $loader        = new ConfigurationFileLoader();
        $configuration = $loader->loadFromFile(new MemoryFileProvider(), $validConfigFile);

        self::assertCount(1, $configuration->plugins);
        self::assertSame(TestPlugin::class, $configuration->plugins[0]->class);

        self::assertCount(1, $configuration->metricGroups);
        self::assertSame('foo', $configuration->metricGroups[0]->identifier);
        self::assertSame('Foo Bar Baz', $configuration->metricGroups[0]->title);

        self::assertCount(2, $configuration->metricGroups[0]->metrics);
        self::assertSame('a_static_integer', $configuration->metricGroups[0]->metrics[0]->metric);
        self::assertSame([], $configuration->metricGroups[0]->metrics[0]->options);

        self::assertSame('a_static_integer', $configuration->metricGroups[0]->metrics[1]->metric);
        self::assertSame([], $configuration->metricGroups[0]->metrics[1]->options);

        self::assertCount(1, $configuration->storage);
        self::assertSame('json', $configuration->storage[0]->identifier);
        self::assertSame(['path' => 'var/metric_storage'], $configuration->storage[0]->options);

        self::assertCount(1, $configuration->reporting);
        self::assertSame('html_report', $configuration->reporting[0]->identifier);
        self::assertSame([], $configuration->reporting[0]->options);
    }
}
