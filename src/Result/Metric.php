<?php

declare(strict_types=1);

namespace Panaly\Result;

use Panaly\Result\Metric\Value;

class Metric
{
    public function __construct(
        public readonly string $title,
        public readonly Value $value,
    ) {
    }
}
