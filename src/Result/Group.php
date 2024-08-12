<?php

declare(strict_types=1);

namespace Panaly\Result;

class Group
{
    /**
     * @param non-empty-string $title
     * @param list<Metric>     $metrics
     */
    public function __construct(
        private readonly string $identifier,
        private readonly string $title,
        private array $metrics = [],
    ) {
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
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

    /** @return array{title: non-empty-string, metrics: array<string, array{title: string, value: mixed}>} */
    public function toArray(): array
    {
        $metricsAsArray = [];
        foreach ($this->metrics as $metric) {
            $metricsAsArray[$metric->identifier] = [
                'title' => $metric->title,
                'value' => $metric->value->format(),
            ];
        }

        return [
            'title' => $this->title,
            'metrics' => $metricsAsArray,
        ];
    }
}
