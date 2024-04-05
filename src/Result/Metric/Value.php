<?php

declare(strict_types=1);

namespace Panaly\Result\Metric;

interface Value
{
    public function compute(): mixed;
}
