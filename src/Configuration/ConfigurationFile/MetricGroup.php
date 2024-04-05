<?php

declare(strict_types=1);

namespace Panaly\Configuration\ConfigurationFile;

use Panaly\Configuration\Exception\InvalidConfigurationFile;

readonly class MetricGroup
{
    /** @param list<Metric> $metrics */
    public function __construct(
        public string $identifier,
        public string $title,
        public array $metrics,
    ) {
        if ($this->identifier === '') {
            throw InvalidConfigurationFile::metricGroupMustNotHaveABlankName();
        }

        if ($this->title === '') {
            throw InvalidConfigurationFile::metricGroupMustNotHaveABlankTitle();
        }
    }
}
