<?php

declare(strict_types=1);

namespace Panaly\Result\Metric;

use function array_merge;

final readonly class Table implements Value
{
    /**
     * @param list<string>      $columns
     * @param list<list<mixed>> $rows
     */
    public function __construct(
        public array $columns,
        public array $rows,
    ) {
    }

    /** @return list<list<mixed>> */
    public function compute(): array
    {
        return array_merge([$this->columns], $this->rows);
    }
}
