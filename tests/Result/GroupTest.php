<?php

declare(strict_types=1);

namespace Panaly\Test\Result;

use Panaly\Result\Group;
use Panaly\Result\Metric;
use Panaly\Result\Metric\IntegerValue;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{
    public function testGetTitle(): void
    {
        $group = new Group('identifier', 'title', []);
        self::assertSame('title', $group->getTitle());
    }

    public function testGetIdentifier(): void
    {
        $group = new Group('identifier', 'title', []);
        self::assertSame('identifier', $group->getIdentifier());
    }

    public function testAddMetric(): void
    {
        $group  = new Group('identifier', 'title', []);
        $metric = new Metric('metric1', 'Metric 1', new IntegerValue(100));
        $group->addMetric($metric);

        self::assertCount(1, $group->getMetrics());
        self::assertSame($metric, $group->getMetrics()[0]);
    }

    public function testToArrayWithEmptyMetrics(): void
    {
        $group    = new Group('identifier', 'title', []);
        $expected = [
            'title' => 'title',
            'metrics' => [],
        ];

        self::assertSame($expected, $group->toArray());
    }

    public function testToArrayWithSingleMetric(): void
    {
        $metric   = new Metric('metric1', 'Metric 1', new IntegerValue(100));
        $group    = new Group('identifier', 'title', [$metric]);
        $expected = [
            'title' => 'title',
            'metrics' => [
                'metric1' => [
                    'title' => 'Metric 1',
                    'value' => 100,
                ],
            ],
        ];

        self::assertSame($expected, $group->toArray());
    }

    public function testToArrayWithMultipleMetrics(): void
    {
        $metric1  = new Metric('metric1', 'Metric 1', new IntegerValue(10000));
        $metric2  = new Metric('metric2', 'Metric 2', new IntegerValue(20000));
        $group    = new Group('identifier', 'title', [$metric1, $metric2]);
        $expected = [
            'title' => 'title',
            'metrics' => [
                'metric1' => [
                    'title' => 'Metric 1',
                    'value' => 10000,
                ],
                'metric2' => [
                    'title' => 'Metric 2',
                    'value' => 20000,
                ],
            ],
        ];

        self::assertSame($expected, $group->toArray());
    }

    public function testGetMetrics(): void
    {
        $metric1 = new Metric('metric1', 'Metric 1', new IntegerValue(100));
        $metric2 = new Metric('metric2', 'Metric 2', new IntegerValue(200));
        $group   = new Group('identifier', 'title', [$metric1, $metric2]);

        $metrics = $group->getMetrics();
        self::assertCount(2, $metrics);
        self::assertSame($metric1, $metrics[0]);
        self::assertSame($metric2, $metrics[1]);
    }
}
