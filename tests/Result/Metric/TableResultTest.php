<?php

declare(strict_types=1);

namespace Panaly\Test\Result\Metric;

use Panaly\Result\Metric\Table;
use PHPUnit\Framework\TestCase;

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
            $metric->compute(),
        );
    }
}
