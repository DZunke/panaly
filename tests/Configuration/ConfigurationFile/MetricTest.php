<?php

declare(strict_types=1);

namespace Panaly\Test\Configuration\ConfigurationFile;

use Panaly\Configuration\ConfigurationFile\Metric;
use Panaly\Configuration\Exception\InvalidConfigurationFile;
use PHPUnit\Framework\TestCase;

class MetricTest extends TestCase
{
    public function testThatTheObjectCanBeBuild(): void
    {
        $metric = new Metric('baz', 'foo', 'bar', []);

        self::assertSame('baz', $metric->identifier);
        self::assertSame('foo', $metric->metric);
        self::assertSame('bar', $metric->title);
        self::assertSame([], $metric->options);
    }

    public function testThatTheMetricMustHaveAnIdentifier(): void
    {
        $this->expectException(InvalidConfigurationFile::class);
        $this->expectExceptionMessage('A metric configuration must have an non-empty identifier.');

        new Metric('', '', null, []);
    }

    public function testThatTheMetricMustHaveAnMetricDefined(): void
    {
        $this->expectException(InvalidConfigurationFile::class);
        $this->expectExceptionMessage('A metric configuration must have an non-empty metric name.');

        new Metric('foo', '', null, []);
    }
}
