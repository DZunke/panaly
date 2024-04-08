<?php

declare(strict_types=1);

namespace Panaly\Configuration\ConfigurationFile;

use Panaly\Configuration\Exception\InvalidConfigurationFile;

class MetricGroup
{
    /** @param list<Metric> $metrics */
    public function __construct(
        public readonly string $identifier,
        public readonly string $title,
        public readonly array $metrics,
    ) {
        if ($this->identifier === '') {
            throw InvalidConfigurationFile::metricGroupMustNotHaveABlankName();
        }

        if ($this->title === '') {
            throw InvalidConfigurationFile::metricGroupMustNotHaveABlankTitle();
        }
    }
}
