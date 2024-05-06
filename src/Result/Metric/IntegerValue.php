<?php

declare(strict_types=1);

namespace Panaly\Result\Metric;

final readonly class IntegerValue implements Value
{
    public function __construct(public int $value)
    {
    }

    public function compute(): int
    {
        return $this->value;
    }
}
