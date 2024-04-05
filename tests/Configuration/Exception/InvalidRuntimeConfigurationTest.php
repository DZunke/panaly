<?php

declare(strict_types=1);

namespace Panaly\Test\Configuration\Exception;

use Panaly\Configuration\Exception\InvalidRuntimeConfiguration;
use PHPUnit\Framework\TestCase;

class InvalidRuntimeConfigurationTest extends TestCase
{
    public function testMetricAlreadyExists(): void
    {
        $exception = InvalidRuntimeConfiguration::metricAlreadyExists('foo_bar');

        self::assertSame(
            'A metric with the name "foo_bar" already exists in runtime.',
            $exception->getMessage(),
        );
    }

    public function testMetricNotExists(): void
    {
        $exception = InvalidRuntimeConfiguration::metricNotExists('foo_bar');

        self::assertSame(
            'A metric with the name "foo_bar" does not exists in runtime.',
            $exception->getMessage(),
        );
    }

    public function testStorageAlreadyExists(): void
    {
        $exception = InvalidRuntimeConfiguration::storageAlreadyExists('foo_bar');

        self::assertSame(
            'A storage with the name "foo_bar" already exists in runtime.',
            $exception->getMessage(),
        );
    }

    public function testStorageNotExists(): void
    {
        $exception = InvalidRuntimeConfiguration::storageNotExists('foo_bar');

        self::assertSame(
            'A storage with the name "foo_bar" does not exists in runtime.',
            $exception->getMessage(),
        );
    }

    public function testReportingAlreadyExists(): void
    {
        $exception = InvalidRuntimeConfiguration::reportingAlreadyExists('foo_bar');

        self::assertSame(
            'A reporting with the name "foo_bar" already exists in runtime.',
            $exception->getMessage(),
        );
    }

    public function testReportingNotExists(): void
    {
        $exception = InvalidRuntimeConfiguration::reportingNotExists('foo_bar');

        self::assertSame(
            'A reporting with the name "foo_bar" does not exists in runtime.',
            $exception->getMessage(),
        );
    }
}
