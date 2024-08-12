<?php

declare(strict_types=1);

namespace Panaly\Test\Result\Metric;

use Panaly\Result\Metric\Table;
use PHPUnit\Framework\TestCase;
use Throwable;

class TableResultTest extends TestCase
{
    public function testTableResultLooksFine(): void
    {
        $metric = new Table(
            ['foo', 'bar'],
            [['bar', 12], ['baz', 13]],
        );

        self::assertSame(
            [['foo', 'bar'], ['bar', 12], ['baz', 13]],
            $metric->format(),
        );
    }

    public function testEmptyColumnsAndRows(): void
    {
        $metric = new Table([], []);
        self::assertSame([[]], $metric->format());
    }

    public function testSingleColumnAndRow(): void
    {
        $metric = new Table(['foo'], [['bar']]);
        self::assertSame([['foo'], ['bar']], $metric->format());
    }

    public function testMixedDataTypes(): void
    {
        $metric = new Table(['foo', 'bar'], [['bar', 12], ['baz', 13.5], ['qux', true]]);
        self::assertSame(
            [['foo', 'bar'], ['bar', 12], ['baz', 13.5], ['qux', true]],
            $metric->format(),
        );
    }

    public function testImmutability(): void
    {
        $metric = new Table(['foo'], [['bar']]);
        try {
            $metric->columns = ['new']; // @phpstan-ignore-line because it is readonly
            self::fail('Expected Error due to readonly property');
        } catch (Throwable $e) {
            self::assertSame('Cannot modify readonly property Panaly\Result\Metric\Table::$columns', $e->getMessage());
        }
    }
}
