<?php

declare(strict_types=1);

namespace Panaly\Event;

use Panaly\Configuration\ConfigurationFile\Metric;

final class BeforeMetricCalculate
{
    public function __construct(
        public readonly Metric $metricConfiguration,
        private array $options,
    ) {
    }

    /** @return array<string, mixed> */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function getOption(string $option): mixed
    {
        return $this->options[$option] ?? null;
    }

    public function setOption(string $option, mixed $value): void
    {
        $this->options[$option] = $value;
    }
}
