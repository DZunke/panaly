<?php

declare(strict_types=1);

namespace Panaly\Result\Metric;

interface Value
{
    public function getRaw(): mixed;

    public function format(): mixed;
}
