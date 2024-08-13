<?php

declare(strict_types=1);

namespace Panaly\Result\Metric;

use function number_format;

final readonly class IntegerValue implements Value
{
    public function __construct(public int $value)
    {
    }

    public function getRaw(): int
    {
        return $this->value;
    }

    public function format(): string
    {
        return number_format(num: $this->value);
    }
}
