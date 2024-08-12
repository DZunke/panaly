<?php

declare(strict_types=1);

namespace Panaly\Result\Metric;

final readonly class IntegerValue implements Value
{
    public function __construct(public int $value)
    {
    }

    public function getRaw(): int
    {
        return $this->format();
    }

    public function format(): int
    {
        return $this->value;
    }
}
