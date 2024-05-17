<?php

declare(strict_types=1);

namespace Panaly\Configuration\ConfigurationFile;

use Panaly\Configuration\Exception\InvalidConfigurationFile;

class Metric
{
    /** @param array<string, mixed> $options */
    public function __construct(
        public readonly string $identifier,
        public readonly string $metric,
        public readonly string|null $title,
        public readonly array $options,
    ) {
        if ($this->identifier === '') {
            throw InvalidConfigurationFile::metricMustNotHaveABlankIdentifier();
        }

        if ($this->metric === '') {
            throw InvalidConfigurationFile::metricMustNotHaveABlankMetric();
        }
    }
}
