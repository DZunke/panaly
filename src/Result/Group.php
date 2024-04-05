<?php

declare(strict_types=1);

namespace Panaly\Result;

class Group
{
    /** @param list<Metric> $metrics */
    public function __construct(
        private readonly string $title,
        private array $metrics = [],
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /** @return list<Metric> */
    public function getMetrics(): array
    {
        return $this->metrics;
    }

    public function addMetric(Metric $metric): void
    {
        $this->metrics[] = $metric;
    }

    /** @return array{title: string, metrics: list<array{title: string, value: mixed}>} */
    public function toArray(): array
    {
        $metricsAsArray = [];
        foreach ($this->metrics as $metric) {
            $metricsAsArray[] = [
                'title' => $metric->title,
                'value' => $metric->value->compute(),
            ];
        }

        return [
            'title' => $this->title,
            'metrics' => $metricsAsArray,
        ];
    }
}
