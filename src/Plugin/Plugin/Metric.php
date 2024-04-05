<?php

declare(strict_types=1);

namespace Panaly\Plugin\Plugin;

use Panaly\Result\Metric\Value;

interface Metric
{
    /** @return non-empty-string */
    public function getIdentifier(): string;

    /** @return non-empty-string */
    public function getDefaultTitle(): string;

    /** @param array<string, mixed> $options */
    public function calculate(array $options): Value;
}
