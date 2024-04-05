<?php

declare(strict_types=1);

namespace Panaly\Test\Configuration\ConfigurationFile;

use Panaly\Configuration\ConfigurationFile\MetricGroup;
use Panaly\Configuration\Exception\InvalidConfigurationFile;
use PHPUnit\Framework\TestCase;

class MetricGroupTest extends TestCase
{
    public function testThatTheObjectIsUsable(): void
    {
        $metricGroup = new MetricGroup('foo', 'bar', []);

        self::assertSame('foo', $metricGroup->identifier);
        self::assertSame('bar', $metricGroup->title);
        self::assertSame([], $metricGroup->metrics);
    }

    public function testThatTheGroupMustHaveAnIdentifier(): void
    {
        $this->expectException(InvalidConfigurationFile::class);
        $this->expectExceptionMessage('A metric group configuration must have an non-empty name.');

        new MetricGroup('', 'bar', []);
    }

    public function testThatTheGroupMustHaveATitle(): void
    {
        $this->expectException(InvalidConfigurationFile::class);
        $this->expectExceptionMessage('A metric group configuration must have an non-empty title option.');

        new MetricGroup('foo', '', []);
    }
}
