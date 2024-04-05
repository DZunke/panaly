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
        $metric = new Metric('foo', 'bar', []);

        self::assertSame('foo', $metric->identifier);
        self::assertSame('bar', $metric->title);
        self::assertSame([], $metric->options);
    }

    public function testThatTheMetricMustHaveAnIdentifier(): void
    {
        $this->expectException(InvalidConfigurationFile::class);
        $this->expectExceptionMessage('A metric configuration must have an non-empty name.');

        new Metric('', null, []);
    }
}
