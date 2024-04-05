<?php

declare(strict_types=1);

namespace Panaly\Test\Configuration\Exception;

use Panaly\Configuration\Exception\InvalidConfigurationFile;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Exception\ParseException;

class InvalidConfigurationFileTest extends TestCase
{
    public function testFileNotFoundException(): void
    {
        $exception = InvalidConfigurationFile::fileNotFound('foo');

        self::assertSame('The config file "foo" is not readable or does not exists!', $exception->getMessage());
    }

    public function testFileContentNotValidYaml(): void
    {
        $previousException = self::createStub(ParseException::class);
        $exception         = InvalidConfigurationFile::fileContentNotValidYaml('foo', $previousException);

        self::assertSame('The configuration file "foo" does not contain valid Yaml content.', $exception->getMessage());
        self::assertSame($previousException, $exception->getPrevious());
    }

    public function testPluginClassNotExists(): void
    {
        $exception = InvalidConfigurationFile::pluginClassNotExists('foo');

        self::assertSame('The plugin class "foo" does not exists.', $exception->getMessage());
    }

    public function testPluginMustImplementPluginInterface(): void
    {
        $exception = InvalidConfigurationFile::pluginMustImplementPluginInterface('Foo/Bar');

        self::assertSame(
            'The class "Foo/Bar" have to implement the interface "Panaly\Plugin\Plugin" for being a plugin.',
            $exception->getMessage(),
        );
    }

    public function testReportingMustNotHaveABlankName(): void
    {
        $exception = InvalidConfigurationFile::reportingMustNotHaveABlankName();

        self::assertSame('A reporting configuration must have an non-empty name.', $exception->getMessage());
    }

    public function testStorageMustNotHaveABlankName(): void
    {
        $exception = InvalidConfigurationFile::storageMustNotHaveABlankName();

        self::assertSame('A storage configuration must have an non-empty name.', $exception->getMessage());
    }

    public function testMetricGroupMustNotHaveABlankName(): void
    {
        $exception = InvalidConfigurationFile::metricGroupMustNotHaveABlankName();

        self::assertSame('A metric group configuration must have an non-empty name.', $exception->getMessage());
    }

    public function testMetricMustNotHaveABlankName(): void
    {
        $exception = InvalidConfigurationFile::metricMustNotHaveABlankName();

        self::assertSame('A metric configuration must have an non-empty name.', $exception->getMessage());
    }

    public function testMetricGroupMustNotHaveABlankTitle(): void
    {
        $exception = InvalidConfigurationFile::metricGroupMustNotHaveABlankTitle();

        self::assertSame('A metric group configuration must have an non-empty title option.', $exception->getMessage());
    }
}
