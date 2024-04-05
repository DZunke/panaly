<?php

declare(strict_types=1);

namespace Panaly\Test\Configuration\ConfigurationFile;

use Panaly\Configuration\ConfigurationFile\Plugin;
use Panaly\Configuration\Exception\InvalidConfigurationFile;
use Panaly\Plugin\Plugin as PluginInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

class PluginTest extends TestCase
{
    public function testThatAPluginCanBeCreated(): void
    {
        $pluginClass = self::createStub(PluginInterface::class);

        $plugin = new Plugin($pluginClass::class);
        self::assertSame($pluginClass::class, $plugin->class);
    }

    public function testThatAnExistingClassMustImplementThePluginInterface(): void
    {
        $this->expectException(InvalidConfigurationFile::class);
        $this->expectExceptionMessage(
            'The class "stdClass" have to implement the interface "Panaly\Plugin\Plugin" for being a plugin.',
        );

        $plugin = new Plugin(stdClass::class);

        self::assertSame(stdClass::class, $plugin->class);
    }

    public function testThatThePluginClassMustExist(): void
    {
        $this->expectException(InvalidConfigurationFile::class);
        $this->expectExceptionMessage('The plugin class "Foo/Bar" does not exists.');

        /** @phpstan-ignore-next-line */
        new Plugin('Foo/Bar');
    }
}
