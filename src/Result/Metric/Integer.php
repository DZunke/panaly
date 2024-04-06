<?php

declare(strict_types=1);

namespace Panaly\Result\Metric;

final readonly class Integer implements Value
{
    public function __construct(private int $value)
    {
    }

    public function compute(): int
    {
        return $this->value;
    }
}