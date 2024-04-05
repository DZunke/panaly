<?php

declare(strict_types=1);

namespace Panaly\Test\Configuration\ConfigurationFile;

use Panaly\Configuration\ConfigurationFile\Reporting;
use Panaly\Configuration\Exception\InvalidConfigurationFile;
use PHPUnit\Framework\TestCase;

class ReportingTest extends TestCase
{
    public function testThatTheObjectCanBeBuild(): void
    {
        $reporting = new Reporting('foo', []);

        self::assertSame('foo', $reporting->identifier);
        self::assertSame([], $reporting->options);
    }

    public function testThatTheReportingMustHaveAnIdentifier(): void
    {
        $this->expectException(InvalidConfigurationFile::class);
        $this->expectExceptionMessage('A reporting configuration must have an non-empty name.');

        new Reporting('', []);
    }
}
