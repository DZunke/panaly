<?php

declare(strict_types=1);

namespace Panaly\Result;

use Panaly\Result\Metric\Value;

readonly class Metric
{
    public function __construct(
        public string $title,
        public Value $value,
    ) {
    }
}
