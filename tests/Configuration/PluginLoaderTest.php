<?php

declare(strict_types=1);

namespace Panaly\Test\Configuration;

use Panaly\Configuration\ConfigurationFile;
use Panaly\Configuration\Exception\PluginLoadingFailed;
use Panaly\Configuration\PluginLoader;
use Panaly\Configuration\RuntimeConfiguration;
use Panaly\Plugin\BasePlugin;
use Panaly\Test\Fixtures\Plugin\TestPlugin;
use PHPUnit\Framework\TestCase;
use stdClass;

use function assert;

class PluginLoaderTest extends TestCase
{
    public function testThatTheInstantiationOfPluginsFailsWithException(): void
    {
        $this->expectException(PluginLoadingFailed::class);
        $this->expectExceptionMessage('The plugin could not be instantiated, maybe an invalid construction?');

        $plugin = new class (new stdClass()) extends BasePlugin {
            /** @phpstan-ignore-next-line */
            public function __construct(stdClass $foo)
            {
            }
        };

        $configurationFile = new ConfigurationFile(
            [new ConfigurationFile\Plugin($plugin::class)],
            [],
            [],
            [],
        );

        $loader = new PluginLoader();
        $loader->load($configurationFile, self::createStub(RuntimeConfiguration::class));
    }

    public function testThatThePluginsAreCorrectLoaded(): void
    {
        $configurationFile = new ConfigurationFile(
            [new ConfigurationFile\Plugin(TestPlugin::class)],
            [],
            [],
            [],
        );

        $runtimeConfiguration = new RuntimeConfiguration();
        $loader               = new PluginLoader();
        $loader->load($configurationFile, $runtimeConfiguration);

        self::assertTrue($runtimeConfiguration->hasMetric('a_static_integer'));
        self::assertTrue($runtimeConfiguration->hasStorage('single_json'));
        self::assertTrue($runtimeConfiguration->hasReporting('symfony_dump'));
    }

    public function testThatOptionsAreHandOverToThePlugin(): void
    {
        $plugin = new class () extends BasePlugin {
            /** @var array{
             *     initialize: array<string, mixed>|null,
             *     metrics: array<string, mixed>|null,
             *     storages: array<string, mixed>|null,
             *     reporting: array<string, mixed>|null
             * }
             */
            public array $expectedCalls = [
                'initialize' => null,
                'metrics' => null,
                'storages' => null,
                'reporting' => null,
            ];

            public function initialize(
                ConfigurationFile $configurationFile,
                RuntimeConfiguration $runtimeConfiguration,
                array $options,
            ): void {
                $this->expectedCalls['initialize'] = $options;
            }

            /** @inheritDoc */
            public function getAvailableMetrics(array $options): array
            {
                $this->expectedCalls['metrics'] = $options;

                return [];
            }

            /** @inheritDoc */
            public function getAvailableStorages(array $options): array
            {
                $this->expectedCalls['storages'] = $options;

                return [];
            }

            /** @inheritDoc */
            public function getAvailableReporting(array $options): array
            {
                $this->expectedCalls['reporting'] = $options;

                return [];
            }
        };

        $pluginOptions     = ['foo' => 'bar'];
        $configurationFile = new ConfigurationFile(
            [new ConfigurationFile\Plugin($plugin::class, $pluginOptions)],
            [],
            [],
            [],
        );

        $runtimeConfiguration = new RuntimeConfiguration();
        $loader               = new PluginLoader();
        $loader->load($configurationFile, $runtimeConfiguration);

        $loadedPlugin = $runtimeConfiguration->getPlugins()[0];
        assert($loadedPlugin instanceof $plugin);

        self::assertIsArray($loadedPlugin->expectedCalls['initialize']);
        self::assertSame($pluginOptions, $loadedPlugin->expectedCalls['initialize']);

        self::assertIsArray($loadedPlugin->expectedCalls['metrics']);
        self::assertSame($pluginOptions, $loadedPlugin->expectedCalls['metrics']);

        self::assertIsArray($loadedPlugin->expectedCalls['storages']);
        self::assertSame($pluginOptions, $loadedPlugin->expectedCalls['storages']);

        self::assertIsArray($loadedPlugin->expectedCalls['reporting']);
        self::assertSame($pluginOptions, $loadedPlugin->expectedCalls['reporting']);
    }
}
