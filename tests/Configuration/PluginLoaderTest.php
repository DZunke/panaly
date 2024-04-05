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
}
